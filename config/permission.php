<?php

return [
    'Global' => array(
        array(
            'permission' => 'superuser',
            'label'      => 'Super User',
            'note'       => 'Determines whether the user has full access to all aspects of the admin. This setting overrides any more specific permissions throughout the system. ',
            'display'    => true,
        ),
    ),
    'Admin' => array(
        array(
            'permission' => 'admin',
            'label'      => '',
            'note'       => 'Determines whether the user has access to most aspects of the admin. ',
            'display'    => true,
        ),
    ),
    'Cashier' => array(
        array(
            'permission' => 'cashier',
            'label'      => '',
            'note'       => 'Determines whether the user has access to most aspects of the Cashier. ',
            'display'    => true,
        ),
    ),
    'Waiter' => array(
        array(
            'permission' => 'waiter',
            'label'      => '',
            'note'       => 'Determines whether the user has access to most aspects of the Waiter. ',
            'display'    => true,
        ),
    ),
    'Reports' => [
        [
            'permission' => 'reports.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Outlet' => [
        [
            'permission' => 'outlet.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'outlet.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'outlet.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'outlet.suspend',
            'label'      => 'Suspend ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Employee' => [
        [
            'permission' => 'employee.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'employee.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'employee.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'employee.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Promo' => [
        [
            'permission' => 'promo.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'promo.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'promo.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'promo.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Categorys' => [
        [
            'permission' => 'category.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'category.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'category.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'category.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Units' => [
        [
            'permission' => 'unit.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'unit.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'unit.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'unit.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Tax' => [
        [
            'permission' => 'tax.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'tax.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'tax.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'tax.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Item' => [
        [
            'permission' => 'item.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item.ingradiant',
            'label'      => 'Ingradiant ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Customer' => [
        [
            'permission' => 'customer.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'customer.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'customer.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'customer.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Account' => [
        [
            'permission' => 'account.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'account.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'account.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'account.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Jurnal' => [
        [
            'permission' => 'jurnal.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'jurnal.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'jurnal.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'jurnal.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'jurnal.preview',
            'label'      => 'Preview ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Cash Bank' => [
        [
            'permission' => 'cash-bank.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'cash-bank.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'cash-bank.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'cash-bank.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'cash-bank.preview',
            'label'      => 'Preview ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'History Journal' => [
        [
            'permission' => 'history-journal.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Cash Bank Preview' => [
        [
            'permission' => 'cash-bank-preview.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'POS' => [
        [
            'permission' => 'pos.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'pos.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'pos.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'pos.suspend',
            'label'      => 'Suspend ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Item Incoming' => [
        [
            'permission' => 'item-incoming.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-incoming.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-incoming.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-incoming.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Item Opname' => [
        [
            'permission' => 'item-opname.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-opname.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-opname.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-opname.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Item Adjustment' => [
        [
            'permission' => 'item-adjustment.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-adjustment.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-adjustment.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'item-adjustment.delete',
            'label'      => 'Delete ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Stock Monitoring' => [
        [
            'permission' => 'stock-monitoring.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Company' => [
        [
            'permission' => 'company.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'company.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'company.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'Group Permissions' => [
        [
            'permission' => 'group-permissions.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'group-permissions.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'group-permissions.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'group-permissions.suspend',
            'label'      => 'Suspend ',
            'note'       => '',
            'display'    => true,
        ],
    ],
    'User' => [
        [
            'permission' => 'user.view',
            'label'      => 'View ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'user.create',
            'label'      => 'Create ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'user.edit',
            'label'      => 'Edit  ',
            'note'       => '',
            'display'    => true,
        ],
        [
            'permission' => 'user.suspend',
            'label'      => 'Suspend ',
            'note'       => '',
            'display'    => true,
        ],
    ],
];
