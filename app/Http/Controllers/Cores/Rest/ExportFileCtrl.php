<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Models\QuestionFormModel;
use App\Models\RoundModel;
use App\Models\RoundOuFormValueModel;
use App\Models\RoundOuModel;
use App\Models\QuestionModel;
use App\Models\QuestionFormDetailModel;
use App\Models\RoundOuMetaModel;
use App\Models\Cores\Cores_ou;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Question\Question;
use Illuminate\Support\Facades\Storage;

class ExportFileCtrl extends RestController
{
    protected $unit_name;

    public function __construct()
    {
        $unit_name = config("app.UNIT_NAME");
        $this->unit_name = mb_strtoupper($unit_name, 'UTF-8');
    }

    private function getStyleExcel()
    {
        return [
            //Border đậm bao ở ngoài, border ở trong cho tất cả các ô
            'borderStyle' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ],
            //Style căn chính giữa
            'normalStyle' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            //Style căn chính giữa, in đậm, chữ trắng, nền vàng
            'borderBoldStyle' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                    'color' => [
                        'argb' => 'FFFFFF'
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'argb' => 'D16300'
                    ],
                ]
            ],
            //Style căn trái, giữa,  in thường
            'normalLeftStyle' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            //Style căn trái, bên trên, in thường
            'borderLeftStyle' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ],
            //Style căn giữa, in đậm
            'boldStyle' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                ],
            ],
            'boldLeftStyle' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                ],
            ]
        ];
    }

    /**
     * Lấy cột theo số
     * @param $c
     * @return string
     */
    private function columnLetter($c)
    {
        $c = intval($c);
        if ($c <= 0) return '';
        $letter = '';
        while ($c != 0) {
            $p = ($c - 1) % 26;
            $c = intval(($c - $p) / 26);
            $letter = chr(65 + $p) . $letter;
        }
        return $letter;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportDocReport(Request $request)
    {
        ob_end_clean();
        // dd($request->roundOuInfo['ou_name']);
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $html = $request->html;
        $html = htmlspecialchars_decode($html);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection([
            'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.8),
            'headerHeight' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.5),
            'footerHeight' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.5),
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.6),
            'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.6),
        ]);
        $styleTable = [
            'borderColor' => '006699',
        ];
        $fontStyle_13 = [
            'bold' => true,
            'align' => 'center',
            'size' => 13,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_14 = [
            'bold' => true,
            'align' => 'center',
            'size' => 14,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_noBold_13 = [
            'bold' => false,
            'align' => 'center',
            'size' => 13,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_noBold_14 = [
            'bold' => false,
            'size' => 14,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_center = [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'align' => \PhpOffice\PhpWord\Style\Cell::AUTO
        ];
        $italic = [
            'italic' => true,
            'name' => 'Times New Roman',
            'size' => 13
        ];
        $marginleft = [
            'cellMarginLeft' => 100
        ];
        $noSpace = array('spaceAfter' => 0, 'align' => 'center');
        $noSpace_1 = array('spaceAfter' => 25, 'align' => 'center');

        // Add table style
        $section->addTableStyle('myOwnTableStyle', $styleTable);
        // Add table
        $table = $section->addTable('myOwnTableStyle');
        // Add row
        $table->addRow();
        // Add cells
        $table->addCell(4800, ['vMerge' => 'restart'])->addText('UBND THÀNH PHỐ BẮC GIANG', $fontStyle_noBold_13, $noSpace);
        $table->addCell(6900)->addText('CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM', $fontStyle_13, $noSpace, $fontStyle_center);
        $table->addRow();
        $table->addCell(4800)->addText("");
        $table->addCell(6900)->addText("Độc lập - Tự do - Hạnh phúc", $fontStyle_14, $noSpace_1);
        $section->addtext('');
        $section->addtext('BÁO CÁO TỔNG HỢP', $fontStyle_14, $noSpace);
        $section->addtext('');
        $section->addtext('');
        $table_resultStyle = array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0);
        $table_resultCell = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
        $section->addTableStyle('ketqua', $table_resultStyle);
        $table_result = $section->addTable('ketqua');


        $table_result->addRow();
        // Add cells
        $table_result->addCell(1000, $table_resultCell)
            ->addText('STT', $fontStyle_13, $fontStyle_center);
        $table_result->addCell(5000, $table_resultCell)
            ->addText('Tên đơn vị', $fontStyle_13, $fontStyle_center);
        $table_result->addCell(3000, $table_resultCell)
            ->addText('Điểm chấm thực tế', $fontStyle_13, $fontStyle_center);
        $table_result->addCell(2000, $table_resultCell)
            ->addText('Xếp loại', $fontStyle_13, $fontStyle_center);
        $section->addtext('');
        $section->addtext('');
        foreach ($request->roundOuInfo['ou'] as $key => $item) {
            $table_result->addRow();
            $table_result->addCell(1000, $table_resultCell)->addText(($key + 1), $fontStyle_noBold_13, $fontStyle_center);
            $table_result->addCell(3000, $table_resultCell)->addText($item['ou_name'], $fontStyle_noBold_13, $marginleft);
            $table_result->addCell(2000, $table_resultCell)->addText($item['point_verify'], $fontStyle_noBold_13, $fontStyle_center);
            $table_result->addCell(1000, $table_resultCell)->addText($item['point_xhh'], $fontStyle_noBold_13, $fontStyle_center);
        }

        $footer = $section->addTable('footer');
        // Add row
        $footer->addRow();
        $footer->addCell(4000)->addText('');
        $footer->addCell(4000)->addText('');
        $footer->addCell(4000)->addText('LÃNH ĐẠO ĐƠN VỊ', $fontStyle_14, $fontStyle_center);
        $footer->addRow();
        $footer->addCell(4000)->addText('');
        $footer->addCell(4000)->addText('');
        $footer->addCell(4000)->addText('(Ký, ghi rõ họ tên)', $italic, $fontStyle_center);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
        header('Content-Type: application/octet-stream');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $date = date("Y_m_d_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Bao_cao_' . $date . '.docx');
            \File::makeDirectory(storage_path('app/public/report'), 0777, true, true);
            $objWriter->save($file_path);
            return response('/storage/report/' . $year . '/Bao_cao_' . $date . '.docx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    public function exportDoc(Request $request)
    {
        ob_end_clean();
       
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $count_1 = 0;
        $count_2 = 0;
        $count_3 = 0;
        $html = $request->html;
        $html = htmlspecialchars_decode($html);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection([
            'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.8),
            'headerHeight' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.5),
            'footerHeight' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.5),
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.6),
            'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(0.6),
        ]);
        $styleTable = [
            'borderColor' => '006699',
        ];
        $fontStyle_13 = [
            'bold' => true,
            'align' => 'center',
            'size' => 13,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_14 = [
            'bold' => true,
            'align' => 'center',
            'size' => 14,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_noBold_13 = [
            'bold' => false,
            'align' => 'center',
            'size' => 13,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_noBold_14 = [
            'bold' => false,
            'align' => 'center',
            'size' => 14,
            'name' => 'Times New Roman',
            'lineHeight' => 1
        ];
        $fontStyle_center = [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
//                'align' => \PhpOffice\PhpWord\Style\Cell::AUTO
        ];
        $noSpace = array('spaceAfter' => 0, 'align' => 'center');
        $noSpace_1 = array('spaceAfter' => 100, 'align' => 'center');
        $addLine_1 = array(
            'spaceBefore' => 3,
            'align' => 'center',
            'weight' => 1,
            'width' => 50,
            'height' => 0,
            'color' => 'black',
        );
        $addLine_2 = array(
            'spaceBefore' => 3,
            'align' => 'center',
            'weight' => 1,
            'width' => 160,
            'height' => 0,
            'color' => 'black',
        );
        $noSpace_2 = array(
            'spaceAfter' => 100,
            'spaceBefore' => 100,
            'align' => 'center',
            'weight' => 1,
            'width' => 160,
            'height' => 0,
            'color' => 'black',
        );
        $italic = [
            'italic' => true,
            'name' => 'Times New Roman',
            'size' => 13
        ];

        // Add table style
        $section->addTableStyle('myOwnTableStyle', $styleTable);
        // Add table
        $table = $section->addTable('myOwnTableStyle');
        // Add row
        $table->addRow();
        // Add cells
        $table->addCell(4800)->addText('UBND THÀNH PHỐ BẮC GIANG', $fontStyle_noBold_13, $noSpace, $fontStyle_center);
        $table->addCell(6900)->addText('CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM', $fontStyle_13, $noSpace, $fontStyle_center);
        $table->addRow();
        $table->addCell(4800)->addText("TỔ CÔNG TÁC", $fontStyle_14, $noSpace_1);
        $table->addCell(6900)->addText("Độc lập - Tự do - Hạnh phúc", $fontStyle_14, $noSpace_1);
        $table->addRow();
        $table->addCell(4800)->addLine($addLine_1);
        $table->addCell(6900)->addLine($addLine_2);
        $section->addtext('BIÊN BẢN KIỂM TRA', $fontStyle_14, $noSpace);
        $section->addtext('Việc thực hiện các điều kiện về phòng, chống dịch Covid-19 tại doanh nghiệp', $fontStyle_14, $noSpace_2);
        $section->addLine(array('weight' => 1, 'width' => 120, 'height' => 0, 'color' => 'black', 'align' => 'center'));
        $section->addtext('     Căn cứ Kế hoạch số 130/KH-UBND ngày 12/7/2021 của UBND thành phố về việc kiểm tra, đánh giá điều kiện sản xuất của doanh nghiệp ngoài khu công nghiệp trên địa bàn thành phố trong trạng thái “Bình thường mới”;', $fontStyle_noBold_14);
        $section->addtext('     Căn cứ Công văn số 2237/UBND-KT ngày 03/8/2021 của UBND thành phố về điều chỉnh một số điều kiện trong Kế hoạch số 130/KH-UBND ngày 12/7/2021 của UBND thành phố;', $fontStyle_noBold_14);
        $section->addtext('     Căn cứ Quyết định số 1962/QĐ-UBND ngày 15/7/2021 của Chủ tịch UBND thành phố về việc kiện toàn Tổ công tác thực hiện kiểm tra công tác phòng, chống dịch Covid-19 tại doanh nghiệp trên địa bàn thành phố;', $fontStyle_noBold_14);
        $section->addtext('     Hôm nay, hồi .... giờ ... phút, ngày ... tháng ... năm ..., tại:', $fontStyle_noBold_14);
        $section->addtext('     - Doanh nghiệp: '.$request->roundOuInfo['ou_name'], $fontStyle_noBold_14);
        $section->addtext('     - Địa chỉ: .................................................', $fontStyle_noBold_14);
        $section->addtext('     Điện thoại liên hệ: ..........................................', $fontStyle_noBold_14);
        $section->addtext('     Người đại diện theo pháp luật: ...............................  Chức vụ: .................', $fontStyle_noBold_14);
        $section->addtext('     Email: .....................................................................................................................', $fontStyle_noBold_14);
        $section->addtext('     I. THÀNH PHẦN', $fontStyle_13);
        $section->addtext('     1. Tổ công tác của thành phố:', $fontStyle_14);
        $section->addtext('     - Ông: ........................Chức vụ: ..........', $fontStyle_noBold_14);
        $section->addtext('     - Bà: .........................Chức vụ: ..........', $fontStyle_noBold_14);
        $section->addtext('     - Bà: .........................Chức vụ: ..........', $fontStyle_noBold_14);
        $section->addtext('     2. Đại diện doanh nghiệp:', $fontStyle_14);
        $section->addtext('     - Ông: ........................... Chức vụ: ............................', $fontStyle_noBold_14);
        $section->addtext('     - Ông: ........................... Chức vụ: ............................', $fontStyle_noBold_14);
        $noidung = $section->addTextRun();
        $noidung->addtext('     II. NỘI DUNG: ', $fontStyle_13);
        $noidung->addtext('Kiểm tra việc thực hiện 24 điều kiện về công tác phòng, chống dịch bệnh Covid-19 tại doanh nghiệp của UBND thành phố theo: Kế hoạch số 130/KH-UBND ngày 09/7/2021 về việc kiểm tra, đánh giá điều kiện sản xuất của doanh nghiệp ngoài khu công nghiệp trên địa bàn thành phố trong trạng thái “Bình thường mới” và Công văn số 2237/UBND-KT ngày 03/8/2021.', $fontStyle_noBold_14);
        $tonglaodong = $section->addtextRun();
        $tonglaodong->addtext('     1. Tổng số lao động tại thời điểm kiểm tra:', $fontStyle_14);
        $tonglaodong->addtext(' ........ lao động.', $fontStyle_noBold_14);
        
        $section->addtext('     2. Kết quả thực hiện của doanh nghiệp:', $fontStyle_14);

        $table_resultStyle = array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0);
        $table_resultCell = array('borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
        $section->addTableStyle('ketqua', $table_resultStyle);
        $table_result = $section->addTable('ketqua');

        $cellRowSpan = array('vMerge' => 'restart', 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
        $cellRowContinue = array('vMerge' => 'continue', 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');
        $cellColSpan = array('gridSpan' => 2, 'borderTopSize' => 1, 'borderTopColor' => 'black', 'borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black');

        $table_result->addRow();
        // Add cells
        $table_result->addCell(1000, $cellRowSpan)
            ->addText('STT', $fontStyle_13, $fontStyle_center);

        $table_result->addCell(3000, $cellRowSpan)
            ->addText('Điều kiện', $fontStyle_13, $fontStyle_center);

        $table_result->addCell(2000, $cellColSpan)
            ->addText('Kết quả', $fontStyle_13, $fontStyle_center);

        $table_result->addCell(1000, $cellRowSpan)
            ->addText('Không áp dụng', $fontStyle_13, $fontStyle_center);

        $note = $table_result->addCell(4000, $cellRowSpan);
        $note->addText('Ghi chú', $fontStyle_13, $fontStyle_center);
        $note->addText('(Ghi nội dung cần làm rõ)', $italic, $fontStyle_center);

        $table_result->addRow();
        // Add cells
        $table_result->addCell(1000, $cellRowContinue);
        $table_result->addCell(3000, $cellRowContinue);
        $table_result->addCell(1000, $table_resultCell)->addText('Đã thực hiện', $fontStyle_13, $fontStyle_center);
        $table_result->addCell(1000, $table_resultCell)->addText('Chưa thực hiện', $fontStyle_13, $fontStyle_center);
        $table_result->addCell(1000, $cellRowContinue);
        $table_result->addCell(4000, $cellRowContinue);

        foreach ($request->roundOuInfo['question_form']['level1'] as $level1) {
            $table_result->addRow();
            $table_result->addCell(1000, $table_resultCell)->addText($level1['index'], $fontStyle_noBold_13, $fontStyle_center);
            $table_result->addCell(3000, $table_resultCell)->addText($level1['title'], $fontStyle_13,array(
                
                'indentation' => array('left' => 50)
            ));
            $col1_1 = $col2_1 = $col3_1 = '';
            if($level1['is_check']){
                $col1_1 = $level1['result']['point_verify'] == 1 ? 'x' : '';
                $col2_1 = $level1['result']['point_verify'] == 2 ? 'x' : '';
                $col3_1 = $level1['result']['point_verify'] == 3 ? 'x' : '';
            }
            $col4_1 = $level1['result']['note_verify'] ?? '';
            $table_result->addCell(1000, $table_resultCell)->addText($col1_1, $fontStyle_noBold_13,$fontStyle_center);
            $table_result->addCell(1000, $table_resultCell)->addText($col2_1, $fontStyle_noBold_13,$fontStyle_center);
            $table_result->addCell(1000, $table_resultCell)->addText($col3_1, $fontStyle_noBold_13,$fontStyle_center);

            $textlines = explode("\n", $col4_1);
            $textrun = $table_result->addCell(4000, $table_resultCell)->addTextRun();
            $textrun->addText(array_shift($textlines),$fontStyle_noBold_13);
            foreach($textlines as $line) {
                $textrun->addTextBreak();
                $textrun->addText($line,$fontStyle_noBold_13);
            }
            



            if (!array_key_exists('level2', $level1))
                continue;

            ///////////////////////////////////// LEVEL 2

            foreach ($level1['level2'] as $level2) {
                $table_result->addRow();
                $table_result->addCell(1000, $table_resultCell)->addText($level2['index'], $fontStyle_noBold_13, $fontStyle_center);
                $table_result->addCell(3000, $table_resultCell)->addText($level2['title'], $fontStyle_noBold_13,array(
                    'indentation' => array('left' => 50)
                ));
                $col1_2 = $col2_2 = $col3_2 = '';
                if($level2['is_check']){
                    $col1_2 = $level2['result']['point_verify'] == 1 ? 'x' : '';
                    $col2_2 = $level2['result']['point_verify'] == 2 ? 'x' : '';
                    $col3_2 = $level2['result']['point_verify'] == 3 ? 'x' : '';
                }
                $col4_2 = $level2['result']['note_verify'] ?? '';
                if($level2['is_import']){
                    $col1_2 = $level2['result']['note_verify'];
                    $col4_2 = '';
                }
                $table_result->addCell(1000, $table_resultCell)->addText($col1_2, $fontStyle_noBold_13,$fontStyle_center);
                $table_result->addCell(1000, $table_resultCell)->addText($col2_2, $fontStyle_noBold_13,$fontStyle_center);
                $table_result->addCell(1000, $table_resultCell)->addText($col3_2, $fontStyle_noBold_13,$fontStyle_center);
                $textlines_2 = explode("\n", $col4_2);
                $textrun_2 = $table_result->addCell(4000, $table_resultCell)->addTextRun();
                $textrun_2->addText(array_shift($textlines_2),$fontStyle_noBold_13);
                foreach($textlines_2 as $line) {
                $textrun_2->addTextBreak();
                $textrun_2->addText($line,$fontStyle_noBold_13);
                }

                if (!array_key_exists('level3', $level2))
                    continue;

                ///////////////////////////////////// LEVEL 3
                foreach ($level2['level3'] as $level3) {
                    $table_result->addRow();
                    $table_result->addCell(1000, $table_resultCell)->addText($level3['index'], $fontStyle_noBold_13, $fontStyle_center);
                    $table_result->addCell(3000, $table_resultCell)->addText('+' . $level3['title'], $italic,array(
                        'indentation' => array('left' => 50)
                    ));
                    $col1_3 = $col2_3 = $col3_3 = '';
                    if($level3['is_check']){
                        $col1_3 = $level3['result']['point_verify'] == 1 ? 'x' : '';
                        $col2_3 = $level3['result']['point_verify'] == 2 ? 'x' : '';
                        $col3_3 = $level3['result']['point_verify'] == 3 ? 'x' : '';
                    }
                    $col4_3 = $level3['result']['note_verify'] ?? '';
                    if($level3['is_import']){
                        $col1_3 = $level3['result']['note_verify'];
                        $col4_3 = '';
                    }
                    $table_result->addCell(1000, $table_resultCell)->addText($col1_3, $fontStyle_noBold_13,$fontStyle_center);
                    $table_result->addCell(1000, $table_resultCell)->addText($col2_3, $fontStyle_noBold_13,$fontStyle_center);
                    $table_result->addCell(1000, $table_resultCell)->addText($col3_3, $fontStyle_noBold_13,$fontStyle_center);
                

                    $textlines_3 = explode("\n", $col4_3);
                    $textrun_3 = $table_result->addCell(4000, $table_resultCell)->addTextRun();
                    $textrun_3->addText(array_shift($textlines_3),$fontStyle_noBold_13);
                    foreach($textlines_3 as $line) {
                    $textrun_3->addTextBreak();
                    $textrun_3->addText($line,$fontStyle_noBold_13);
                    }

                }
            }

        }
        $section->addText('', $fontStyle_noBold_13);
        $finished=$section->addTextRun();
        $finished->addText('     * Tổng số điều kiện đã thực hiện: ',$fontStyle_noBold_14);
        $finished->addText($request->roundOuInfo['finished'], $fontStyle_14);

        $unfinished=$section->addTextRun();
        $unfinished->addText('     * Tổng số điều kiện chưa thực hiện: ',$fontStyle_noBold_14);
        $unfinished->addText($request->roundOuInfo['unfinished'], $fontStyle_14);
        
        $not_apply=$section->addTextRun();
        $not_apply->addText('     * Tổng số điều kiện không áp dụng: ',$fontStyle_noBold_14);
        $not_apply->addText($request->roundOuInfo['not_apply'], $fontStyle_14);

        $section->addText('     * Kết luận: ', $fontStyle_14);
        $textbox=$section->addTableStyle('box');
        $textbox=$section->addTable('box');
        
        if($request->roundOuInfo['eligible']==1){
            $textbox->addRow();
            $textbox->addCell(4000)->addText('      Đủ điều kiện hoạt động:', $fontStyle_noBold_14);
            $textbox->addCell(500,$table_resultCell)->addText('x', $fontStyle_noBold_14,$fontStyle_center);
            $textbox->addRow();
            $textbox->addCell(4000)->addText('      Không đủ điều kiện hoạt động:', $fontStyle_noBold_14);
            $textbox->addCell(500);
        }
        else if($request->roundOuInfo['eligible']==2){
            $textbox->addRow();
            $textbox->addCell(4000)->addText('      Đủ điều kiện hoạt động:', $fontStyle_noBold_14);
            $textbox->addCell(500);
            $textbox->addRow();
            $textbox->addCell(4000)->addText('      Không đủ điều kiện hoạt động:', $fontStyle_noBold_14);
            $textbox->addCell(500,$table_resultCell)->addText('x', $fontStyle_noBold_14,$fontStyle_center);
        }
        else{
            $textbox->addRow();
            $textbox->addCell(4000)->addText('      Đủ điều kiện hoạt động:', $fontStyle_noBold_14);
            $textbox->addCell(500);
            $textbox->addRow();
            $textbox->addCell(4000)->addText('      Không đủ điều kiện hoạt động:', $fontStyle_noBold_14);
            $textbox->addCell(500);
        }
        
        
        $section->addPageBreak();
        $section->addText('III. Ý KIẾN CỦA DOANH NGHIỆP', $fontStyle_14);
        $section->addText('……………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ', $fontStyle_noBold_14);
        $section->addText('IV. Ý KIẾN CỦA TỔ CÔNG TÁC', $fontStyle_14);

        $section->addText('……………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ………………………………………………………………...………………………..
        ', $fontStyle_noBold_14);

        $section->addText('Buổi kiểm tra kết thúc hồi ..........h.......... cùng ngày, biên bản được thông qua các thành phần dự buổi thẩm định cùng nghe và thống nhất ký tên dưới đây./.', $fontStyle_noBold_14);
        $footer = $section->addTableStyle('footer', $styleTable);
        // Add table
        $footer = $section->addTable('footer');
        // Add row
        $footer->addRow();
        $footer->addCell(4000)->addText('NGƯỜI LẬP BIÊN BẢN', $fontStyle_14);
        $footer->addCell(4000)->addText('ĐD. TỔ KIỂM TRA', $fontStyle_14, $fontStyle_center);
        $footer->addCell(4000)->addText('ĐD. DOANH NGHIỆP', $fontStyle_14, $fontStyle_center);
        $footer->addRow();
        $footer->addCell(4000)->addText('(Ký, ghi rõ họ tên)', $italic, $fontStyle_center);
        $footer->addCell(4000)->addText('(Ký, ghi rõ họ tên)', $italic, $fontStyle_center);
        $footer->addCell(4000)->addText('(Ký, ghi rõ họ tên, đóng dấu)', $italic, $fontStyle_center);

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
        header('Content-Type: application/octet-stream');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $date = date("Y_m_d_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Bao_cao_' . $date . '.docx');
            \File::makeDirectory(storage_path('app/public/report'), 0777, true, true);
            $objWriter->save($file_path);
            return response('/storage/report/' . $year . '/Bao_cao_' . $date . '.docx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    //Render cho các level 2,3,4,5
    function renderChild($spreadsheet, $level, $startRow, $borderLeftStyle)
    {
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, $level['result']['point']);
        // Nếu có giải trình
        $reasons = '';
        if (array_key_exists('reason', $level['result'])) {
            if (count($level['result']['reason'])) {
                $reasons = 'Giải trình: ' . "\r";
                foreach ($level['result']['reason'] as $reason) {
                    $reasons = $reasons . ' - ' . $reason['round_form_value_meta_value'] . "\r";
                }
            }
        }
        // Nếu có tài liệu kiểm chứng
        $files = '';
        if (array_key_exists('file', $level['result'])) {
            if (count($level['result']['file'])) {
                $files = 'Tài liệu kiểm chứng: ' . "\r";
                foreach ($level['result']['file'] as $file) {
                    if (array_key_exists('round_form_value_meta_value', $file)) {
                        foreach ($file['round_form_value_meta_value'] as $item) {
                            $files = $files . ' - ' . $item['filename'] . "\r";
                        }
                    }
                }
            }
        }
        $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, $reasons . $files);
        $spreadsheet->getActiveSheet()->getStyle('D' . $startRow)->applyFromArray($borderLeftStyle);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, $level['result']['point_verify']);
        // Nếu có ý kiến thẩm định
        $reasons_verify = "";
        if (array_key_exists('reason_verify', $level['result'])) {
            if (trim($level['result']['reason_verify']) != "") {
                $reasons_verify = 'Ý kiến: ' . "\r" . $level['result']['reason_verify'];
            }
        }
        // Nếu có tài liệu
        $files = '';
        if (array_key_exists('file_verify', $level['result'])) {
            if (count($level['result']['file_verify'])) {
                $files = 'Tài liệu : ' . "\r";
                foreach ($level['result']['file_verify'] as $file) {
                    $files = $files . ' - ' . $file['filename'] . "\r";
                }
            }
            $spreadsheet->getActiveSheet()->setCellValue('F' . $startRow, $reasons_verify . "\r" . $files);
            $spreadsheet->getActiveSheet()->getStyle('F' . $startRow)->applyFromArray($borderLeftStyle);
        } else {
            $spreadsheet->getActiveSheet()->setCellValue('F' . $startRow, '');
        }
    }

    public function exportExcel(Request $request)
    {
        $ouName = $request->roundOuInfo['ou_name'];
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40.86);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $ouNameUpp = mb_strtoupper($ouName, 'UTF-8');
        $spreadsheet->getActiveSheet()->mergeCells('A1:C2')->setCellValue('A1', $ouNameUpp);
        $spreadsheet->getActiveSheet()->mergeCells('D1:F1')->setCellValue('D1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('D2:F2')->setCellValue('D2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:F5')->setCellValue('A5', 'KẾT QUẢ ĐÁNH GIÁ ĐÁNH GIÁ NGUY CƠ LÂY NHIỄM');
        $spreadsheet->getActiveSheet()->mergeCells('A6:F6')->setCellValue('A6', 'Doanh nghiệp: ' . $ouName);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $spreadsheet->getActiveSheet()->mergeCells('A7:F7')->setCellValue('A7', 'Ngày ' . $day . ' Tháng ' . $month . ' Năm ' . $year);

        $spreadsheet->getActiveSheet()->setCellValue('A9', 'Nội dung');
        $spreadsheet->getActiveSheet()->setCellValue('B9', 'Điểm chuẩn');
        $spreadsheet->getActiveSheet()->setCellValue('C9', 'Tự chấm');
        $spreadsheet->getActiveSheet()->setCellValue('D9', 'Tài liệu kiểm chứng/Giải trình');
        $spreadsheet->getActiveSheet()->setCellValue('E9', 'Điểm chấm thực tế');
        $spreadsheet->getActiveSheet()->setCellValue('F9', 'Ý kiến');
        $spreadsheet->getActiveSheet()->getStyle('A9:F9')->applyFromArray($style['borderBoldStyle']);

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 10; // Hàng bắt đầu
        $total = 0;  // Tổng điểm
        $result_point = 0;  // Tổng điểm tự đánh giá
        $result_point_verify = 0;  // Tổng điểm thẩm định
        //////////////////////////////// LEVEL 1
        foreach ($request->roundOuInfo['question_form']['level1'] as $level1) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, $level1['index'] . '. ' . $level1['title']);
            $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['boldLeftStyle']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level1['point']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, $level1['result']['point']);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, '');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, $level1['result']['point_verify']);
            $spreadsheet->getActiveSheet()->setCellValue('F' . $startRow, '');
            $startRow++;
            $total += $level1['point'];
            $result_point += $level1['result']['point'];
            $result_point_verify += $level1['result']['point_verify'];
            if (!array_key_exists('level2', $level1))
                continue;

            ///////////////////////////////////// LEVEL 2
            foreach ($level1['level2'] as $level2) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '     ' . $level2['index'] . '. ' . $level2['title']);
                $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level2['point']);
                if (isset($level2['result'])) {
                    $this->renderChild($spreadsheet, $level2, $startRow, $style['borderLeftStyle']);
                }
                $startRow++;

                /////////////////////////////////////// LEVEL 3
                if (!array_key_exists('level3', $level2))
                    continue;
                foreach ($level2['level3'] as $level3) {
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '          ' . $level3['index'] . '. ' . $level3['title']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level3['point']);

                    if (isset($level3['result'])) {
                        $this->renderChild($spreadsheet, $level3, $startRow, $style['borderLeftStyle']);
                    }
                    $startRow++;
                    /////////////////////////////////////// LEVEL 4
                    if (!key_exists('level4', $level3))
                        continue;
                    foreach ($level3['level4'] as $level4) {
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '               ' . $level4['index'] . '. ' . $level4['title']);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level4['point']);
                        if (isset($level4['result'])) {
                            $this->renderChild($spreadsheet, $level4, $startRow, $style['borderLeftStyle']);
                        }
                        $startRow++;
                        if (!key_exists('level5', $level4))
                            continue;
                        //////////////////////////////////////////// LEVEL 5
                        foreach ($level4['level5'] as $level5) {
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '                    ' . $level5['index'] . '. ' . $level5['title']);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level5['point']);
                            if (isset($level5['result'])) {
                                $this->renderChild($spreadsheet, $level5, $startRow, $style['borderLeftStyle']);
                            }
                            $startRow++;
                        }
                    }
                }
            }
        }
        //Tính tổng điểm
        $point_remove = isset($request->roundOuInfo['point_remove']) ? $request->roundOuInfo['point_remove'] : 0;
        $total_point = isset($request->roundOuInfo['question_form']['total_point']) ? $request->roundOuInfo['question_form']['total_point'] : 0;

        $total = round($total_point - $point_remove, 3);
        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, 'Tổng điểm');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $total);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, $result_point);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, $result_point_verify);
        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':' . 'F' . $startRow)->applyFromArray($style['borderBoldStyle']);
        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 4), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 5), ' (Ký và ghi rõ họ tên)');
        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A9:F' . $startRow)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A9:F' . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Bao_cao_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Bao_cao_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Bao_cao_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    public function exportExcel_check(Request $request)
    {
        $ouName = $request->roundOuInfo['ou_name'];
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40.86);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(9.29);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(40);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $ouNameUpp = mb_strtoupper($ouName, 'UTF-8');
        $spreadsheet->getActiveSheet()->mergeCells('A1:C2')->setCellValue('A1', $ouNameUpp);
        $spreadsheet->getActiveSheet()->mergeCells('D1:F1')->setCellValue('D1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('D2:F2')->setCellValue('D2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:F5')->setCellValue('A5', 'KẾT QUẢ ĐÁNH GIÁ ĐÁNH GIÁ NGUY CƠ LÂY NHIỄM');
        $spreadsheet->getActiveSheet()->mergeCells('A6:F6')->setCellValue('A6', 'Doanh nghiệp: ' . $ouName);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $spreadsheet->getActiveSheet()->mergeCells('A7:F7')->setCellValue('A7', 'Ngày ' . $day . ' Tháng ' . $month . ' Năm ' . $year);

        $spreadsheet->getActiveSheet()->setCellValue('A9', 'Nội dung');
        $spreadsheet->getActiveSheet()->setCellValue('B9', 'Điểm chuẩn');
        $spreadsheet->getActiveSheet()->setCellValue('C9', 'Tự chấm');
        $spreadsheet->getActiveSheet()->setCellValue('D9', 'Tài liệu kiểm chứng/Giải trình');
        $spreadsheet->getActiveSheet()->setCellValue('E9', 'Điểm chấm thực tế');
        $spreadsheet->getActiveSheet()->setCellValue('F9', 'Ý kiến');
        $spreadsheet->getActiveSheet()->setCellValue('G9', 'Tài liệu kiểm chứng/Giải trình');
        $spreadsheet->getActiveSheet()->setCellValue('H9', 'Điểm chấm thực tế');
        $spreadsheet->getActiveSheet()->setCellValue('I9', 'Ý kiến');

        $spreadsheet->getActiveSheet()->getStyle('A9:I9')->applyFromArray($style['borderBoldStyle']);

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 10; // Hàng bắt đầu
        $total = 0;  // Tổng điểm
        $result_point = 0;  // Tổng điểm tự đánh giá
        $result_point_verify = 0;  // Tổng điểm thẩm định
        //////////////////////////////// LEVEL 1
        foreach ($request->roundOuInfo['question_form']['level1'] as $level1) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, $level1['index'] . '. ' . $level1['title']);
            $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['boldLeftStyle']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level1['point']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, '');
            $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, '');
            $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, '');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $startRow, '');
            $startRow++;
            $total += $level1['point'];
            $result_point += $level1['result']['point'];
            $result_point_verify += $level1['result']['point_verify'];
            if (!array_key_exists('level2', $level1))
                continue;

            ///////////////////////////////////// LEVEL 2
            foreach ($level1['level2'] as $level2) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '     ' . $level2['index'] . '. ' . $level2['title']);
                $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level2['point']);
                if (isset($level2['result'])) {
                    $this->renderChild($spreadsheet, $level2, $startRow, $style['borderLeftStyle']);
                }
                $startRow++;

                /////////////////////////////////////// LEVEL 3
                if (!array_key_exists('level3', $level2))
                    continue;
                foreach ($level2['level3'] as $level3) {
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '          ' . $level3['index'] . '. ' . $level3['title']);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level3['point']);

                    if (isset($level3['result'])) {
                        $this->renderChild($spreadsheet, $level3, $startRow, $style['borderLeftStyle']);
                    }
                    $startRow++;
                    /////////////////////////////////////// LEVEL 4
                    if (!key_exists('level4', $level3))
                        continue;
                    foreach ($level3['level4'] as $level4) {
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '               ' . $level4['index'] . '. ' . $level4['title']);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level4['point']);
                        if (isset($level4['result'])) {
                            $this->renderChild($spreadsheet, $level4, $startRow, $style['borderLeftStyle']);
                        }
                        $startRow++;
                        if (!key_exists('level5', $level4))
                            continue;
                        //////////////////////////////////////////// LEVEL 5
                        foreach ($level4['level5'] as $level5) {
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '                    ' . $level5['index'] . '. ' . $level5['title']);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $startRow)->applyFromArray($style['borderLeftStyle']);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $level5['point']);
                            if (isset($level5['result'])) {
                                $this->renderChild($spreadsheet, $level5, $startRow, $style['borderLeftStyle']);
                            }
                            $startRow++;
                        }
                    }
                }
            }
        }
        //Tính tổng điểm
        $point_remove = isset($request->roundOuInfo['point_remove']) ? $request->roundOuInfo['point_remove'] : 0;
        $total_point = isset($request->roundOuInfo['question_form']['total_point']) ? $request->roundOuInfo['question_form']['total_point'] : 0;

        $total = round($total_point - $point_remove, 3);
        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, 'Tổng điểm');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $total);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, $result_point);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, $result_point_verify);
        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':' . 'F' . $startRow)->applyFromArray($style['borderBoldStyle']);
        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 4), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 5), ' (Ký và ghi rõ họ tên)');
        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A9:F' . $startRow)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A9:F' . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Bao_cao_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Bao_cao_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Bao_cao_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo tổng hợp
    public function exportExcel1(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);
        $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('C1:D1')->setCellValue('C1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('C2:D2')->setCellValue('C2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('B5:C5')->setCellValue('B5', 'BÁO CÁO TỔNG HỢP');
        $title_sub = mb_strtoupper($request->title_sub, 'UTF-8');
        $level = $request->level;
        $spreadsheet->getActiveSheet()->mergeCells('B6:C6')->setCellValue('B6', $title_sub);
        $spreadsheet->getActiveSheet()->getStyle('B6')->getFont()->setSize(11);
        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu

        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, 'STT');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, 'Tên đơn vị');
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, 'Điểm chấm thực tế');
        $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, 'Xếp loại');
        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':D' . $startRow)->applyFromArray($style['borderBoldStyle']);

        foreach ($request->arr_round as $key => $item) {
            if ($item['rank'] == 1) {
                $rank = 'Xếp loại A';
            }
            if ($item['rank'] == 2) {
                $rank = 'Xếp loại B';
            }
            if ($item['rank'] == 3) {
                $rank = 'Xếp loại C';
            }

            $point = round($item['point_xhh'] + $item['point_verify'] - $item['minus_point'], 2);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), ($key + 1));
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $item['ou_name']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 1), $item['point_verify']);
            $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 1), $rank);

            $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $startRow++;
        }

        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 2), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 3), ' (Ký và ghi rõ họ tên)');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A8:D' . $startRow)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A8:D' . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Tong_hop_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Tong_hop_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Tong_hop_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo chi tiết từng đơn vị
    public function exportExcel2(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('C1:G1')->setCellValue('C1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('C2:G2')->setCellValue('C2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:G5')->setCellValue('A5', 'BÁO CÁO CHI TIẾT TỪNG ĐƠN VỊ');
        $title_sub = mb_strtoupper($request->title_sub, 'UTF-8');
        $spreadsheet->getActiveSheet()->mergeCells('A6:G6')->setCellValue('A6', $title_sub);
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(11);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $max_point = 0; // điểm tối đa
        $self_evaluate_point = 0; // điểm tự chấm
        $verified_point = 0; // điểm thẩm định
        $minus_point = 0; // điểm bị trừ
        $minus_point_verify = 0; // điểm thẩm định sau khi trừ

        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, 'Tiêu chí');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, 'Nội dung');
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, 'Điểm tối đa');
        $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, 'Điểm tự chấm');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, 'Điểm thẩm định');
        $spreadsheet->getActiveSheet()->setCellValue('F' . $startRow, 'Điểm bị trừ');
        $spreadsheet->getActiveSheet()->setCellValue('G' . $startRow, 'Điểm thẩm định sau khi trừ');
        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':G' . $startRow)->applyFromArray($style['borderBoldStyle']);

        foreach ($request->groupQuestion as $row) {
            $point_minus_verify = round($row['point_verify'] - $row['minus_point'], 2);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), (array_search($row, $request->groupQuestion) + 1));
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $row['title']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 1), $row['total_point']);
            $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 1), $row['point']);
            $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 1), $row['point_verify']);
            $spreadsheet->getActiveSheet()->setCellValue('F' . ($startRow + 1), $row['minus_point']);
            $spreadsheet->getActiveSheet()->setCellValue('G' . ($startRow + 1), $point_minus_verify);
            $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['normalLeftStyle']);
            $startRow++;
            $max_point += $row['total_point'];
            $self_evaluate_point += $row['point'];
            $verified_point += $row['point_verify'];
            $minus_point += $row['minus_point'];
            $minus_point_verify += $point_minus_verify;
        }
        $spreadsheet->getActiveSheet()->mergeCells('A' . ($startRow + 1) . ':B' . ($startRow + 1))->setCellValue('A' . ($startRow + 1), 'Tổng cộng');
        $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 1), $max_point);
        $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 1), $self_evaluate_point);
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 1), $verified_point);
        $spreadsheet->getActiveSheet()->setCellValue('F' . ($startRow + 1), $minus_point);
        $spreadsheet->getActiveSheet()->setCellValue('G' . ($startRow + 1), $minus_point_verify);
        $spreadsheet->getActiveSheet()->getStyle('A' . ($startRow + 1) . ':G' . ($startRow + 1))->applyFromArray($style['boldStyle']);

        if (!$request->is_minus_point) {
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setVisible(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setVisible(false);
        }

        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 4), ' LÃNH ĐẠO ĐƠN VỊ');
        $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 5), ' (Ký và ghi rõ họ tên)');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A8:G' . ($startRow + 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A8:G' . ($startRow + 1))->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Don_vi_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Don_vi_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Don_vi_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo tổng hợp theo lĩnh vực
    public function exportExcel3(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(6);

        $spreadsheet->getActiveSheet()->getRowDimension(8)->setRowHeight(130);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('F1:T1')->setCellValue('F1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('F2:T2')->setCellValue('F2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:T5')->setCellValue('A5', 'BÁO CÁO TỔNG HỢP THEO LĨNH VỰC');
        $title_sub = mb_strtoupper($request->title_sub, 'UTF-8');
        $spreadsheet->getActiveSheet()->mergeCells('A6:T6')->setCellValue('A6', $title_sub);
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(11);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $numStartColumn = 2;//Cột
        $is_minus_point = $request->is_minus_point;

        $spreadsheet->getActiveSheet()->mergeCells('A' . $startRow . ':A' . ($startRow + 2))->setCellValue('A' . $startRow, 'STT');
        $spreadsheet->getActiveSheet()->mergeCells('B' . $startRow . ':B' . ($startRow + 2))->setCellValue('B' . $startRow, 'Tên đơn vị');
        for ($i = 0; $i < count($request->ou[0]['question_form']); $i++) {
            $numStartColumn++;
            $startColumn = $this->columnLetter($numStartColumn);
            $columnTd = $this->columnLetter($numStartColumn + 1);
            $columnMinus = $this->columnLetter($numStartColumn + 2);
            $columnTotal = $this->columnLetter($numStartColumn + 3);
            $titleCol = $request->ou[0]['question_form'][$i]['title'] . ' (' . $request->ou[0]['question_form'][$i]['total_point'] . ' điểm)';
            $spreadsheet->getActiveSheet()->mergeCells($startColumn . $startRow . ':' . $columnTotal . $startRow)->setCellValue($startColumn . $startRow, $titleCol);
            $spreadsheet->getActiveSheet()->mergeCells($startColumn . ($startRow + 1) . ':' . $columnTotal . ($startRow + 1))->setCellValue($startColumn . ($startRow + 1), $i + 1);
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 2), 'TC');
            $spreadsheet->getActiveSheet()->setCellValue($columnTd . ($startRow + 2), 'TĐ');
            $spreadsheet->getActiveSheet()->setCellValue($columnMinus . ($startRow + 2), 'Bị trừ');
            $spreadsheet->getActiveSheet()->setCellValue($columnTotal . ($startRow + 2), 'Tổng');
            $numStartColumn += 3;
        }
        $startColumn = $this->columnLetter($numStartColumn + 1);
        $columnTd = $this->columnLetter($numStartColumn + 2);
        $endColumn = $this->columnLetter($numStartColumn + 4);
        $spreadsheet->getActiveSheet()->mergeCells($startColumn . $startRow . ':' . $endColumn . $startRow)->setCellValue($startColumn . $startRow, 'Tổng điểm');
        $spreadsheet->getActiveSheet()->mergeCells($startColumn . ($startRow + 1) . ':' . $endColumn . ($startRow + 1))->setCellValue($startColumn . ($startRow + 1), $i + 1);
        $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 2), 'TC');
        $spreadsheet->getActiveSheet()->setCellValue($columnTd . ($startRow + 2), 'TĐ');

        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ":" . $endColumn . ($startRow + 2))->applyFromArray($style['borderBoldStyle']);

        foreach ($request['ou'] as $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 3), (array_search($item, $request['ou']) + 1));
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 3), $item['ou_name']);
            $startColumn = 'C';
            $tc_point = 0;
            $td_point_verify = 0;
            $td_minus_point = 0;
            $td_minus_point_verify = 0;
            foreach ($item['question_form'] as $row) {
                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $row['point']);
                $tc_point += $row['point'];
                if ($is_minus_point) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($startColumn)->setVisible(false);
                }
                $startColumn++;

                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $row['point_verify']);
                $td_point_verify += $row['point_verify'];
                $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 3))->applyFromArray($style['boldStyle']);
                $startColumn++;

                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $row['minus_point']);
                $td_minus_point += $row['minus_point'];
                $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 3));
                //Ẩn cột khi không bị trừ điểm
                if (!$is_minus_point) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($startColumn)->setVisible(false);
                }
                $startColumn++;
                $minus_point_verify = round($row['point_verify'] - $row['minus_point'], 2);
                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $minus_point_verify);
                $td_minus_point_verify += $minus_point_verify;
                $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 3))->applyFromArray($style['boldStyle']);
                if (!$is_minus_point) {
                    $spreadsheet->getActiveSheet()->getColumnDimension($startColumn)->setVisible(false);
                }
                $startColumn++;
            }
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $tc_point);
            if ($is_minus_point) {
                $spreadsheet->getActiveSheet()->getColumnDimension($startColumn)->setVisible(false);
            }
            $startColumn++;
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $td_point_verify);
            $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 3))->applyFromArray($style['boldStyle']);
            $startColumn++;
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $td_minus_point);
            //Ẩn cột khi không bị trừ điểm
            if (!$is_minus_point) {
                $spreadsheet->getActiveSheet()->getColumnDimension($startColumn)->setVisible(false);
            }

            $startColumn++;
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 3), $td_minus_point_verify);
            $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 3))->applyFromArray($style['boldStyle']);
            //Ẩn cột khi không bị trừ điểm
            if (!$is_minus_point) {
                $spreadsheet->getActiveSheet()->getColumnDimension($startColumn)->setVisible(false);
            }
            $startRow++;
        }
        $startRow++;

        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('O' . ($startRow + 5), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('O' . ($startRow + 6), ' (Ký và ghi rõ họ tên)');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle("A8:$endColumn" . ($startRow + 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A8:$endColumn" . ($startRow + 1))->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Linh_vuc_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Linh_vuc_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Linh_vuc_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo tổng hợp theo lĩnh vực
    public function exportExcel3b(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);

        $spreadsheet->getActiveSheet()->getRowDimension(8)->setRowHeight(130);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('C1:D1')->setCellValue('C1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('C2:D2')->setCellValue('C2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:D5')->setCellValue('A5', 'BÁO CÁO TỔNG HỢP THEO LĨNH VỰC');
        $title_sub = mb_strtoupper($request->title_sub, 'UTF-8');
        $spreadsheet->getActiveSheet()->mergeCells('A6:D6')->setCellValue('A6', $title_sub);
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(11);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $numStartColumn = 2;//Cột
        $is_minus_point = $request->is_minus_point;

        $spreadsheet->getActiveSheet()->mergeCells('A' . $startRow . ':A' . ($startRow + 1))->setCellValue('A' . $startRow, 'STT');
        $spreadsheet->getActiveSheet()->mergeCells('B' . $startRow . ':B' . ($startRow + 1))->setCellValue('B' . $startRow, 'Tên đơn vị');
        $title = $request->data['title'] . " (tối đa " . $request->data['total_point'] . "điểm)";
        $spreadsheet->getActiveSheet()->mergeCells('C' . $startRow . ':D' . $startRow)->setCellValue('C' . $startRow, $title);
        $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 1), 'Điểm');
        $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 1), 'Chỉ số %');

        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ":D" . ($startRow + 1))->applyFromArray($style['borderBoldStyle']);
        $startRow++;
        foreach ($request['data']['ou'] as $item) {
            $startRow++;
            $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, (array_search($item, $request['data']['ou']) + 1));
            $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, $item['ou_name']);
            $spreadsheet->getActiveSheet()->getStyle('B' . $startRow)->applyFromArray($style['normalLeftStyle']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, $item['total_point']);
            $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, $item['index']);

        }
        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 5), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 6), ' (Ký và ghi rõ họ tên)');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle("A8:D" . $startRow)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A8:D" . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Linh_vuc_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Linh_vuc_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Linh_vuc_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo tổng theo lĩnh vực
    public function exportExcel4(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();
        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
//        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
//        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(8);
//        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(8);
//
        $spreadsheet->getActiveSheet()->getRowDimension(8)->setRowHeight(130);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $numStartColumn = 2;//Cộp bắt đầu "B"
        $arrColumnHide = [];//danh sách cột ẩn

        $spreadsheet->getActiveSheet()->mergeCells('A' . $startRow . ':A' . ($startRow + 2))->setCellValue('A' . $startRow, 'STT');
        $spreadsheet->getActiveSheet()->mergeCells('B' . $startRow . ':B' . ($startRow + 2))->setCellValue('B' . $startRow, 'Tên đơn vị');
        for ($i = 0; $i < count($request->groupQuestion['ou'][0]['level2']); $i++) {
            $columnTC = $this->columnLetter($numStartColumn + 1);
            $columnTD = $this->columnLetter($numStartColumn + 2);
            $columnBT = $this->columnLetter($numStartColumn + 3);
            $columnTg = $this->columnLetter($numStartColumn + 4);
            if ($request->is_minus_point) {
                $arrColumnHide[] = $columnTC;
            } else {
                $arrColumnHide[] = $columnBT;
                $arrColumnHide[] = $columnTg;
            }

            $spreadsheet->getActiveSheet()->mergeCells($columnTC . $startRow . ':' . $columnTg . $startRow)
                ->setCellValue($columnTC . $startRow, $request->groupQuestion['ou'][0]['level2'][$i]['title'] . ' (' . $request->groupQuestion['ou'][0]['level2'][$i]['total_point'] . ' điểm)');
            $spreadsheet->getActiveSheet()->mergeCells($columnTC . ($startRow + 1) . ':' . $columnTg . ($startRow + 1))->setCellValue($columnTC . ($startRow + 1), ($i + 1));
            $spreadsheet->getActiveSheet()->setCellValue($columnTC . ($startRow + 2), 'TC');
            $spreadsheet->getActiveSheet()->setCellValue($columnTD . ($startRow + 2), 'TĐ');
            $spreadsheet->getActiveSheet()->setCellValue($columnBT . ($startRow + 2), 'Trừ điểm');
            $spreadsheet->getActiveSheet()->setCellValue($columnTg . ($startRow + 2), 'Tổng');
            $numStartColumn += 4;
        }

        $columnTC = $this->columnLetter($numStartColumn + 1);
        $columnTD = $this->columnLetter($numStartColumn + 2);
        $columnBT = $this->columnLetter($numStartColumn + 3);
        $columnTg = $this->columnLetter($numStartColumn + 4);
        if ($request->is_minus_point) {
            $arrColumnHide[] = $columnTC;
        } else {
            $arrColumnHide[] = $columnBT;
            $arrColumnHide[] = $columnTg;
        }

        $spreadsheet->getActiveSheet()->mergeCells($columnTC . $startRow . ':' . $columnTg . $startRow)->setCellValue($columnTC . $startRow, 'Tổng điểm');
        $spreadsheet->getActiveSheet()->mergeCells($columnTC . ($startRow + 1) . ':' . $columnTg . ($startRow + 1))->setCellValue($columnTC . ($startRow + 1), ($i + 1));
        $spreadsheet->getActiveSheet()->setCellValue($columnTC . ($startRow + 2), 'TC');
        $spreadsheet->getActiveSheet()->setCellValue($columnTD . ($startRow + 2), 'TĐ');
        $spreadsheet->getActiveSheet()->setCellValue($columnBT . ($startRow + 2), 'Trừ điểm');
        $spreadsheet->getActiveSheet()->setCellValue($columnTg . ($startRow + 2), 'Tổng');

        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':' . $columnTg . ($startRow + 2))->applyFromArray($style['borderBoldStyle']);

        foreach ($request->groupQuestion['ou'] as $item) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 3), (array_search($item, $request->groupQuestion['ou']) + 1));
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 3), $item['ou_name']);
            $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 3))->applyFromArray($style['normalLeftStyle']);
            $numStartColumn = 2;//Cộp bắt đầu "B"

            foreach ($item['level2'] as $row) {
                $columnTC = $this->columnLetter($numStartColumn + 1);
                $columnTD = $this->columnLetter($numStartColumn + 2);
                $columnBT = $this->columnLetter($numStartColumn + 3);
                $columnTg = $this->columnLetter($numStartColumn + 4);

                $spreadsheet->getActiveSheet()->setCellValue($columnTC . ($startRow + 3), $row['point']);
                $spreadsheet->getActiveSheet()->setCellValue($columnTD . ($startRow + 3), $row['point_verify']);
                $spreadsheet->getActiveSheet()->setCellValue($columnBT . ($startRow + 3), $row['minus_point']);
                $minus_point_verify = round($row['point_verify'] - $row['minus_point'], 2);
                $spreadsheet->getActiveSheet()->setCellValue($columnTg . ($startRow + 3), $minus_point_verify);
                $spreadsheet->getActiveSheet()->getStyle($columnTg . ($startRow + 3))->applyFromArray($style['boldStyle']);
                $numStartColumn += 4;
            }
            $columnTC = $this->columnLetter($numStartColumn + 1);
            $columnTD = $this->columnLetter($numStartColumn + 2);
            $columnBT = $this->columnLetter($numStartColumn + 3);
            $columnTg = $this->columnLetter($numStartColumn + 4);
            $spreadsheet->getActiveSheet()->setCellValue($columnTC . ($startRow + 3), $item['level1']['point']);
            $spreadsheet->getActiveSheet()->setCellValue($columnTD . ($startRow + 3), $item['level1']['point_verify']);
            $spreadsheet->getActiveSheet()->setCellValue($columnBT . ($startRow + 3), $item['level1']['minus_point']);
            $minus_point_verify = round($item['level1']['point_verify'] - $item['level1']['minus_point'], 2);
            $spreadsheet->getActiveSheet()->setCellValue($columnTg . ($startRow + 3), $minus_point_verify);
            $spreadsheet->getActiveSheet()->getStyle($columnTg . ($startRow + 3))->applyFromArray($style['boldStyle']);
            $startRow++;
        }
        $startRow++;
        $startColumn = $columnTg;

        foreach ($arrColumnHide as $col) {
            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setVisible(false);
        }

        if (count($request->groupQuestion['ou'][0]['level2']) < 3) {

            // Ghi quốc hiêu, tiêu ngữ, tiêu đề
            $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
            $spreadsheet->getActiveSheet()->mergeCells('C1:' . $startColumn . '1')->setCellValue('C1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
            $spreadsheet->getActiveSheet()->mergeCells('C2:' . $startColumn . '2')->setCellValue('C2', 'Độc lập - Tự do - Hạnh phúc');
            $spreadsheet->getActiveSheet()->mergeCells('A5:' . $startColumn . '5')->setCellValue('A5', $request->groupQuestion['title'] . ' ' . $request->type);

            // Chữ ký của lãnh đạo
            $spreadsheet->getActiveSheet()->mergeCells('E' . ($startRow + 5) . ':F' . ($startRow + 5))->setCellValue('E' . ($startRow + 5), ' LÃNH ĐẠO ĐƠN VỊ ');
            $spreadsheet->getActiveSheet()->mergeCells('E' . ($startRow + 6) . ':F' . ($startRow + 6))->setCellValue('E' . ($startRow + 6), ' (Ký và ghi rõ họ tên) ');
        } else {
            // Ghi quốc hiêu, tiêu ngữ, tiêu đề
            $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
            $spreadsheet->getActiveSheet()->mergeCells('F1:' . $startColumn . '1')->setCellValue('F1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
            $spreadsheet->getActiveSheet()->mergeCells('F2:' . $startColumn . '2')->setCellValue('F2', 'Độc lập - Tự do - Hạnh phúc');
            $spreadsheet->getActiveSheet()->mergeCells('A5:' . $startColumn . '5')->setCellValue('A5', $request->groupQuestion['title'] . ' ' . $request->type);
            $spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);

            // Chữ ký của lãnh đạo
            $spreadsheet->getActiveSheet()->mergeCells('H' . ($startRow + 5) . ':J' . ($startRow + 5))->setCellValue('H' . ($startRow + 5), ' LÃNH ĐẠO ĐƠN VỊ ');
            $spreadsheet->getActiveSheet()->mergeCells('H' . ($startRow + 6) . ':J' . ($startRow + 6))->setCellValue('H' . ($startRow + 6), ' (Ký và ghi rõ họ tên) ');
        }

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $startColumn . ($startRow + 8))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A8:' . $startColumn . ($startRow + 1))->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Linh_vuc_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Linh_vuc_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Linh_vuc_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    private function getBackgroundColor($number)
    {
        $backgroundColor = ['bb3179', 'bf3039', '09a253', '91434b', '32bdd9', '5c4059', '3f69bf', 'd7df52', 'a0bdcd', 'e8858f', '51e07e', '093184'];
        return [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'argb' => $backgroundColor[$number]
                ],
            ],
        ];
    }

    // Báo cáo phân tích tiêu chí
    public function exportExcel5(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        $initalCol = 'B';
        for ($i = 0; $i < array_sum($request->roundOuInfo['arr_column']) + $request->roundOuInfo['column']; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($initalCol++)->setWidth(7);
        }
        $upperOuName = mb_strtoupper($request->roundOuInfo['ou_name'], 'UTF-8'); //tên đơn vị viết hoa
        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $startCol = 'B';
        $startColNumber = 2;  // Chỉ số hàng bắt đầu
        // bắt đầu ghi dữ liệu
        $spreadsheet->getActiveSheet()->mergeCells('A' . $startRow . ':A' . ($startRow + 1))->setCellValue('A' . $startRow, 'TIÊU CHÍ VÀ LĨNH VỰC');
        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':A' . ($startRow + 1))->applyFromArray($style['borderBoldStyle']);
        $index = 0; // chỉ số của nhóm tiêu chí đang ghi
        //Ghi tiêu đề cột
        foreach ($request->roundOuInfo['arr_column'] as $item) {
            $index++;
            $firstCol = $startCol;
            for ($i = 0; $i <= $item; $i++) {
                $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 1), 'TC TP' . ($i + 1));
                if ($i == $item) {
                    $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 1), 'TĐ TC' . $index);
                    $spreadsheet->getActiveSheet()->getStyle($startCol . ($startRow + 1))->applyFromArray($style['boldStyle']);
                    $spreadsheet->getActiveSheet()->mergeCells($firstCol . $startRow . ':' . $startCol . $startRow)->setCellValue($firstCol . $startRow, 'TC' . $index);
                    $spreadsheet->getActiveSheet()->getStyle($firstCol . $startRow . ':' . $startCol . $startRow)->applyFromArray($style['borderBoldStyle']);
                }
                $startCol++;
                $startColNumber++;
            }
        }
        $spreadsheet->getActiveSheet()->mergeCells($startCol . $startRow . ':' . $startCol . ($startRow + 1))->setCellValue($startCol . $startRow, 'Điểm');
        $spreadsheet->getActiveSheet()->getStyle($startCol . $startRow . ':' . $startCol . ($startRow + 1))->applyFromArray($style['borderBoldStyle']);

        $index = 0; // chỉ số
        foreach ($request->roundOuInfo['level1'] as $item) {
            $startCol = 'B';
            $startColNumber = 2;
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 2), 'LV' . ($index + 1));
            $spreadsheet->getActiveSheet()->getStyle('A' . ($startRow + 2))->applyFromArray($style['borderBoldStyle']);

            //ghi từng hàng
            for ($i = 0; $i < $request->roundOuInfo['column']; $i++) {
                // ghi từng nhóm tiêu chí
                for ($j = 0; $j < $request->roundOuInfo['arr_column'][$i]; $j++) {
                    $val = isset($item['level2']) && isset($item['level2'][$i]) && isset($item['level2'][$i]['level3']) && isset($item['level2'][$i]['level3'][$j]) ? $item['level2'][$i]['level3'][$j]['point_verify'] : null;
                    if ($val === null) {
                        $spreadsheet->getActiveSheet()->getStyle($startCol . ($startRow + 2))->applyFromArray($this->getBackgroundColor($i));
                    } else {
                        $val_minus = isset($item['level2']) && isset($item['level2'][$i]) && isset($item['level2'][$i]['level3']) && isset($item['level2'][$i]['level3'][$j]) ? $item['level2'][$i]['level3'][$j]['minus_point'] : 0;
                        $val = round($val - $val_minus, 2);
                    }
                    $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 2), $val);
                    $startCol++;
                    $startColNumber++;
                }
                $val = isset($item['level2']) && isset($item['level2'][$i]) ? $item['level2'][$i]['point_verify'] : null;
                if ($val === null) {
                    $spreadsheet->getActiveSheet()->getStyle($startCol . ($startRow + 2))->applyFromArray($this->getBackgroundColor($i));
                } else {
                    $val_minus = isset($item['level2']) && isset($item['level2'][$i]) ? $item['level2'][$i]['minus_point'] : 0;
                    $val = round($val - $val_minus, 2);
                }
                $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 2), $val);
                $spreadsheet->getActiveSheet()->getStyle($startCol . ($startRow + 2))->applyFromArray($style['boldStyle']);

                $startCol++;
                $startColNumber++;
            }
            $total_point_verify = round($item['point_verify'] - $item['minus_point'], 2);
            $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 2), $total_point_verify);
            $spreadsheet->getActiveSheet()->getStyle($startCol . ($startRow + 2))->applyFromArray($style['borderBoldStyle']);

            $startRow++;
            $index++;
        }

        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, $startRow + 2, $startColNumber - 1, $startRow + 2);
        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $startRow + 2, 'Tổng điểm');

        $total_point = round($request->roundOuInfo['point_verify'] + $request->roundOuInfo['point_xhh'] - $request->roundOuInfo['minus_point'], 2);
        $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 2), $total_point);
        $spreadsheet->getActiveSheet()->getStyle('A' . ($startRow + 2) . ':' . $startCol . ($startRow + 2))->applyFromArray($style['borderBoldStyle']);

        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, 1, 5, 2)->setCellValueByColumnAndRow(1, 1, 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(6, 1, $startColNumber, 1)->setCellValueByColumnAndRow(6, 1, 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(6, 2, $startColNumber, 2)->setCellValueByColumnAndRow(6, 2, 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow(1, 5, $startColNumber, 5)->setCellValue('A5', 'BÁO CÁO PHÂN TÍCH TIÊU CHÍ ' . $upperOuName . ' ĐỢT ĐÁNH GIÁ NĂM ' . $request->year);

        //  Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('Z' . ($startRow + 4), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('Z' . ($startRow + 5), ' (Ký và ghi rõ họ tên)');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A8:' . $startCol . ($startRow + 2))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A8:' . $startCol . ($startRow + 2))->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Tong_hop_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Tong_hop_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Tong_hop_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo tổng hợp
    public function exportExcel6(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('C1:F1')->setCellValue('C1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('C2:F2')->setCellValue('C2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:F5')->setCellValue('A5', 'BÁO CÁO KẾT QUẢ CHỈ SỐ CCHC');
        $title_sub = mb_strtoupper($request->title_sub, 'UTF-8');
        $spreadsheet->getActiveSheet()->mergeCells('A6:F6')->setCellValue('A6', $title_sub);
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(11);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $arr_type_xhh = array_keys(config('parIndex.type-xhh'));

        foreach ($request->arr_round as $round) {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $startRow . ':A' . ($startRow + 1))->setCellValue('A' . $startRow, 'Xếp hạng');
            $spreadsheet->getActiveSheet()->mergeCells('B' . $startRow . ':B' . ($startRow + 1))->setCellValue('B' . $startRow, 'Tên đơn vị');
            $spreadsheet->getActiveSheet()->mergeCells('C' . $startRow . ':C' . ($startRow + 1))->setCellValue('C' . $startRow, 'Điểm thẩm định');
            $startCol = 'C';
            $total_point_type_xhh = 0;
            foreach ($arr_type_xhh as $type_xhh) {
                $startCol++;
                $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 1), $type_xhh);
            }
            $spreadsheet->getActiveSheet()->mergeCells('D' . $startRow . ":$startCol" . $startRow)->setCellValue('D' . $startRow, 'Điểm đánh giá tác động của CCHC');
            $startCol++;
            $spreadsheet->getActiveSheet()->mergeCells($startCol . $startRow . ":$startCol" . ($startRow + 1))->setCellValue($startCol . $startRow, 'Tổng điểm đạt được');
            $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ":$startCol" . ($startRow + 1))->applyFromArray($style['borderBoldStyle']);


            foreach ($round['ou'] as $item) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 2), (array_search($item, $round['ou']) + 1));
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 2), $item['ou_name']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 2), $item['point_verify']);
                $startCol = 'C';
                $total_point_type_xhh = 0;
                foreach ($arr_type_xhh as $type_xhh) {
                    $startCol++;
                    if (isset($item['point_xhh_by_type'][$type_xhh])) {
                        $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 2), $item['point_xhh_by_type'][$type_xhh]);
                    }
                    $point_type_xhh = 0;
                    if (array_key_exists($type_xhh, $item['point_xhh_by_type'])) {
                        $point_type_xhh = $item['point_xhh_by_type'][$type_xhh];
                    }
                    $total_point_type_xhh += $point_type_xhh;
                }
                $startCol++;
                $spreadsheet->getActiveSheet()->setCellValue($startCol . ($startRow + 2), $item['point_verify'] + $total_point_type_xhh);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 2))->applyFromArray($style['normalLeftStyle']);

                $startRow++;
            }
            $startRow++;
        }

        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 3), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 4), ' (Ký và ghi rõ họ tên)');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle("A8:$startCol" . $startRow)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A8:$startCol" . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('Tong_hop_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/Tong_hop_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/Tong_hop_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo tổng theo lĩnh vực
    public function exportExcel8(Request $request)
    {
        $show_detail = $request->show_detail;
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
//
        $spreadsheet->getActiveSheet()->getRowDimension(8)->setRowHeight(130);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu
        $startColumn = 'C';

        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, 'STT');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, 'Nội dung');
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, 'Điểm tối đa');
        for ($i = 0; $i < count($request->data['ou']); $i++) {
            $startColumn++;
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . $startRow, $request->data['ou'][$i]['ou_name']);
        }

        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':' . $startColumn . $startRow)->applyFromArray($style['borderBoldStyle']);

        foreach ($request->data['question_form'] as $level1) {
            $startColumn = 'C';
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), $level1['index']);
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $level1['title']);
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $level1['point']);
            $spreadsheet->getActiveSheet()->getStyle('A' . ($startRow + 1))->applyFromArray($style['boldStyle']);
            $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['boldLeftStyle']);
            $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 1))->applyFromArray($style['boldStyle']);
            foreach ($level1['resultOu'] as $row) {
                $startColumn++;
                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $row['point_verify']);
                $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 1))->applyFromArray($style['boldStyle']);
            }
            $startRow++;
            foreach ($level1['level2'] as $level2) {
                $startColumn = 'C';
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), $level2['index']);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $level2['title']);
                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $level2['point']);
                if ($show_detail) {
                    $spreadsheet->getActiveSheet()->getStyle('A' . ($startRow + 1))->applyFromArray($style['boldStyle']);
                    $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['boldLeftStyle']);
                    $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 1))->applyFromArray($style['boldStyle']);
                }
                foreach ($level2['resultOu'] as $row) {
                    $startColumn++;
                    $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $row['point_verify']);
                    if ($show_detail) {
                        $spreadsheet->getActiveSheet()->getStyle($startColumn . ($startRow + 1))->applyFromArray($style['boldStyle']);
                    }
                }
                $startRow++;
                if (!isset($level2['level3'])) {
                    continue;
                }
                foreach ($level2['level3'] as $level3) {
                    $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), $level3['index']);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $level3['title']);
                    $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['normalLeftStyle']);
                    $startColumn = 'C';
                    $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $level3['point']);
                    foreach ($level3['resultOu'] as $row) {
                        $startColumn++;
                        $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $row['point_verify']);
                    }
                    $startRow++;
                    if (!isset($level2['level3'])) {
                        continue;
                    }
                    foreach ($level3['level4'] as $level4) {
                        $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), $level4['index']);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $level4['title']);
                        $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['normalLeftStyle']);
                        $startColumn = 'C';
                        $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $level4['point']);
                        foreach ($level4['resultOu'] as $row) {
                            $startColumn++;
                            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $row['point_verify']);
                        }
                        $startRow++;
                        if (!isset($level2['level3'])) {
                            continue;
                        }
                        foreach ($level4['level5'] as $level5) {
                            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), $level5['index']);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $level5['title']);
                            $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['normalLeftStyle']);
                            $startColumn = 'C';
                            $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $level5['point']);
                            foreach ($level5['resultOu'] as $row) {
                                $startColumn++;
                                $spreadsheet->getActiveSheet()->setCellValue($startColumn . ($startRow + 1), $row['point_verify']);
                            }
                            $startRow++;
                        }
                    }
                }
            }
        }
        $startRow++;
        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, '');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, 'Tổng điểm');
        $spreadsheet->getActiveSheet()->getStyle('B' . $startRow)->applyFromArray($style['boldStyle']);
        $startColumn = 'C';
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, '100');
        for ($i = 0; $i < count($request->data['ou']); $i++) {
            $startColumn++;
            $total_point = round(($request->data['ou'][$i]['point_verify'] + $request->data['ou'][$i]['point_xhh']), 2);
            $spreadsheet->getActiveSheet()->setCellValue($startColumn . $startRow, $total_point);
            $spreadsheet->getActiveSheet()->getStyle($startColumn . $startRow)->applyFromArray($style['boldStyle']);

        }

        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('F1:' . $startColumn . '1')->setCellValue('F1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('F2:' . $startColumn . '2')->setCellValue('F2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:' . $startColumn . '5')->setCellValue('A5', 'BÁO CÁO KẾT QUẢ THẨM ĐỊNH ' . $request->type . ' NĂM ' . $request->year);
        $spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);

        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->mergeCells('H' . ($startRow + 5) . ':J' . ($startRow + 5))->setCellValue('H' . ($startRow + 5), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->mergeCells('H' . ($startRow + 6) . ':J' . ($startRow + 6))->setCellValue('H' . ($startRow + 6), ' (Ký và ghi rõ họ tên) ');


        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $startColumn . ($startRow + 8))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A8:' . $startColumn . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('ket_qua_tham_dinh_' . $day . '_' . $month . '_' . $year);


        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/ket_qua_tham_dinh_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/ket_qua_tham_dinh_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    // Báo cáo 10
    public function exportExcel10(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        //Chọn trang cần ghi (là số từ 0->n)
        $spreadsheet->setActiveSheetIndex(0);
        $style = $this->getStyleExcel();

        //Set font và cỡ chữ cho toàn bộ sheet
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getDefaultStyle()->applyFromArray($style['normalStyle']);

        // Đặt kích cỡ cho từng cột
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(35);
//
        $spreadsheet->getActiveSheet()->getRowDimension(8)->setRowHeight(130);

        // Bắt đầu ghi dữ liệu
        $date = new \DateTime();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Thực hiện thêm dữ liệu vào từng ô
        $startRow = 8; // Hàng bắt đầu

        $total_point = isset($request->data['ou'][0]) ? $request->data['ou'][0]['total_point'] : 0;
        $spreadsheet->getActiveSheet()->setCellValue('A' . $startRow, 'STT');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $startRow, 'Đơn vị');
        $spreadsheet->getActiveSheet()->setCellValue('C' . $startRow, 'Điểm thẩm định thực tế');
        $spreadsheet->getActiveSheet()->setCellValue('D' . $startRow, 'Tỷ lệ % thực hiện nhiệm vụ');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $startRow, "Điểm thẩm định (Tối đa $total_point)");
        $spreadsheet->getActiveSheet()->setCellValue('F' . $startRow, 'Điểm điều tra XHH');
        $spreadsheet->getActiveSheet()->setCellValue('G' . $startRow, 'Điểm đo lường hài lòng');
        $spreadsheet->getActiveSheet()->setCellValue('H' . $startRow, 'Tổng điểm');
        $spreadsheet->getActiveSheet()->setCellValue('I' . $startRow, 'Các tiêu chí đặc thù không đáng giá');
        $spreadsheet->getActiveSheet()->getStyle('A' . $startRow . ':I' . $startRow)->applyFromArray($style['borderBoldStyle']);

        for ($i = 0; $i < count($request->data['ou']); $i++) {
            $roundOuInfo = $request->data['ou'][$i];
            $point_verify_front = $roundOuInfo['point_verify_front'] . '/' . round($roundOuInfo['total_point'] - $roundOuInfo['point_remove'], 2);
            $ty_le = round($roundOuInfo['point_verify_front'] / ($roundOuInfo['total_point'] - $roundOuInfo['point_remove']) * 100, 2);
            $point_xhh = round($roundOuInfo['point_xhh'] - $roundOuInfo['point_sipas'], 2);
            $total_point = round($roundOuInfo['point_xhh'] + $roundOuInfo['point_verify'], 2);
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($startRow + 1), $i + 1);
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($startRow + 1), $roundOuInfo['ou_name']);
            $spreadsheet->getActiveSheet()->setCellValue('C' . ($startRow + 1), $point_verify_front);
            $spreadsheet->getActiveSheet()->setCellValue('D' . ($startRow + 1), $ty_le);
            $spreadsheet->getActiveSheet()->setCellValue('E' . ($startRow + 1), $roundOuInfo['point_verify']);
            $spreadsheet->getActiveSheet()->setCellValue('F' . ($startRow + 1), $point_xhh);
            $spreadsheet->getActiveSheet()->setCellValue('G' . ($startRow + 1), $roundOuInfo['point_sipas']);
            $spreadsheet->getActiveSheet()->setCellValue('H' . ($startRow + 1), $total_point);
            $text_question = '';
            foreach ($roundOuInfo['question'] as $question) {
                $text_question .= $question['index'] . '. ' . $question['title'] . '(' . $question['point'] . " điểm) \r";
            }
            $spreadsheet->getActiveSheet()->setCellValue('I' . ($startRow + 1), $text_question);
            $spreadsheet->getActiveSheet()->getStyle('B' . ($startRow + 1))->applyFromArray($style['normalLeftStyle']);
            $spreadsheet->getActiveSheet()->getStyle('I' . ($startRow + 1))->applyFromArray($style['normalLeftStyle']);
            $startRow++;
        }

        // Ghi quốc hiêu, tiêu ngữ, tiêu đề
        $spreadsheet->getActiveSheet()->mergeCells('A1:B2')->setCellValue('A1', 'UBND ' . $this->unit_name);
        $spreadsheet->getActiveSheet()->mergeCells('F1:I1')->setCellValue('F1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $spreadsheet->getActiveSheet()->mergeCells('F2:I2')->setCellValue('F2', 'Độc lập - Tự do - Hạnh phúc');
        $spreadsheet->getActiveSheet()->mergeCells('A5:I5')->setCellValue('A5', 'BÁO CÁO ĐẶC THÙ ' . $request->type . ' NĂM ' . $request->year);
        $spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setWrapText(true);

        // Chữ ký của lãnh đạo
        $spreadsheet->getActiveSheet()->mergeCells('H' . ($startRow + 5) . ':J' . ($startRow + 5))->setCellValue('H' . ($startRow + 5), ' LÃNH ĐẠO ĐƠN VỊ ');
        $spreadsheet->getActiveSheet()->mergeCells('H' . ($startRow + 6) . ':J' . ($startRow + 6))->setCellValue('H' . ($startRow + 6), ' (Ký và ghi rõ họ tên) ');

        //Border cho toàn bộ các ô chứa dữ liệu
        $spreadsheet->getActiveSheet()->getStyle('A1:I' . ($startRow + 8))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A8:I' . $startRow)->applyFromArray($style['borderStyle']);
        $spreadsheet->getActiveSheet()->setTitle('ket_qua_dac_thu_' . $day . '_' . $month . '_' . $year);

        try {
            $date = date("d_m_Y_H_i_s", time());
            $file_path = storage_path('app/public/report/' . $year . '/ket_qua_dac_thu_' . $date . '.xlsx');
            \File::makeDirectory(storage_path('app/public/report/' . $year), 0777, true, true);
            $writer->save($file_path);
            return response('/storage/report/' . $year . '/ket_qua_dac_thu_' . $date . '.xlsx');
        } catch (Exception $e) {
            return response($e->getMessage(), 422);
        }
    }

    public function exportExcel11(Request $request, Cores_ou $cores_ou)
    {
        $params = $request->all();
        $params['limit'] = 0;
        $params['verify'] = $params['verify'] ?? 1;
        $data = $cores_ou->getAll($params)->toArray();

        $spread_sheet = new Spreadsheet();
        $style = $this->getStyleExcel();
        $start_row = 8;
        $sheet = $spread_sheet->getActiveSheet();

        $spread_sheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spread_sheet->getDefaultStyle()->getFont()->setSize(14);
        $spread_sheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);

        $sheet->mergeCells('A1:C2')->setCellValue('A1', 'UBND THÀNH PHỐ BẮC GIANG');
        $sheet->mergeCells('E1:F1')->setCellValue('E1', 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
        $sheet->mergeCells('E2:F2')->setCellValue('E2', 'Độc lập - Tự do - Hạnh phúc');
        $sheet->mergeCells('C5:E5')->setCellValue('C5', 'THÔNG TIN DOANH NGHIỆP');
        $sheet->mergeCells('C6:E6')->setCellValue('C6', 'Ngày ' . Date('d') . ' tháng ' . Date('m') . ' năm ' . Date('Y'));

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(40);

        $sheet->setCellValue('A' . $start_row, 'STT');
        $sheet->setCellValue('B' . $start_row, 'Tên doanh nghiệp');
        $sheet->setCellValue('C' . $start_row, 'Mã số thuế');
        $sheet->setCellValue('D' . $start_row, 'Loại hình');
        $sheet->setCellValue('E' . $start_row, 'Ngành nghề');
        $sheet->setCellValue('F' . $start_row, 'Địa chỉ');

        $spread_sheet->getActiveSheet()->getStyle('A' . $start_row . ':F' . $start_row)->applyFromArray($style['borderBoldStyle']);
        $start_row++;

        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $start_row, $key + 1);
            $sheet->setCellValue('B' . $start_row, $value['ou_name'] ?? '');
            $sheet->setCellValue('C' . $start_row, $value['tax_code'] ?? '');
            $sheet->setCellValue('D' . $start_row, $value['enterprise_type_info']['name'] ?? '');
            $sheet->setCellValue('E' . $start_row, $value['career_info']['name'] ?? '');
            $sheet->setCellValue('F' . $start_row, $value['address'] ?? '');
            $start_row++;
        }

        $spread_sheet->getActiveSheet()->getStyle('A1:F' . $start_row)->getAlignment()->setWrapText(true);
        $spread_sheet->getActiveSheet()->getStyle('A1:F' . $start_row)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spread_sheet->getActiveSheet()->getStyle('A1:F' . $start_row)
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spread_sheet->getActiveSheet()->getStyle('A8:F' . $start_row)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spread_sheet->getActiveSheet()->getStyle('B9:B' . $start_row)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spread_sheet->getActiveSheet()->getStyle('D9:F' . $start_row)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $time = date("d_m_Y_H_i_s", time());
        $directory = 'public/ou_info';
        $store_folder = Storage::files($directory);
        if (count($store_folder) > 1) {
            Storage::deleteDirectory($directory);
        }
        Storage::makeDirectory($directory);

        $writer = new Xlsx($spread_sheet);
        $writer->save('storage/ou_info/Thong_tin_doanh_nghiep_' . $time . '.xlsx');
        return response()->json('storage/ou_info/Thong_tin_doanh_nghiep_' . $time . '.xlsx');
    }

}
