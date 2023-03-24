<?php
/**
 * Chức danh người sử dụng
 */
return [
    'menu-left' => [ [
        'label' => 'Sản phẩm',
        'permit' => [
            'dochoi-danhmuc' => [
                'class_icon' => 'bx bxl-product-hunt',
                'label' => 'Danh mục sản phẩm'
            ],
            'dochoi-loaisanpham' => [
                'class_icon' => 'fa fa-cube',
                'label' => 'Loại sản phẩm'
            ],
            'dochoi-san-pham' => [
                'class_icon' => 'bx bx-map',
                'label' => 'Danh sách sản phẩm'
            ],
            'dochoi-mau' => [
                'class_icon' => 'bx bxl-product-hunt',
                'label' => 'Danh sách màu sản phẩm'
            ],
            'dochoi-don-hang' => [
                'class_icon' => 'bx bxl-product-hunt',
                'label' => 'Danh sách đơn hàng'
            ],
        ]
    ],  [
        'label' => 'Quản trị hệ thống',
        'permit' => [
            'group-user' => [
                'class_icon' => 'bx bxs-user',
                'label' => 'Quản trị người sử dụng',
                'permit' => [
                    'group' => [
                        'class_icon' => 'bx bx-user-plus',
                        'label' => 'Nhóm người sử dụng'
                    ],
                    'user' => [
                        'class_icon' => 'bx bx-user',
                        'label' => 'Người sử dụng'
                    ],
                ]
            ],
            'group-category' => [
                'class_icon' => 'bx bx-list-ul',
                'label' => 'Quản trị các danh mục',
                'permit' => [
                    'province' => [
                        'class_icon' => 'bx bxs-city',
                        'label' => 'Quản lý Tỉnh/Thành phố'
                    ],
                    'district' => [
                        'class_icon' => 'bx bx-building-house',
                        'label' => 'Quản lý Quận/Huyện'
                    ],
                    'village' => [
                        'class_icon' => 'bx bx-buildings',
                        'label' => 'Quản lý Phường/Xã'
                    ],
                ]
            ],
        ]
    ]],
];