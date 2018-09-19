<?php
namespace Aht\BannerSlider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

//      if version 1 < version 2
        if (version_compare($context->getVersion(), '1.1.0', '<')) {

//            tạo bảng banner slide, nên chỉnh option
            if (!$installer->tableExists('banner_slide')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('banner_slide')
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'banner_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable => false'],
                        'Banner ID'
                    )
                    ->addColumn(
                        'slide_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable => false'],
                        'Slide ID'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                        'Created At'
                    )->addColumn(
                        'updated_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At')
                    ->setComment('Banner Slide Table');

                $installer->getConnection()->createTable($table);
            }

//            tạo bảng banner_page
            if (!$installer->tableExists('banner_page')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('banner_page')
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'banner_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['nullable => false'],
                        'Banner ID'
                    )
                    ->addColumn(
                        'page_url',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Page Url'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                        'Created At'
                    )->addColumn(
                        'updated_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At')
                    ->setComment('Banner Page Table');

                $installer->getConnection()->createTable($table);
            }

//          Sử dụng để tạo fulltext search
            if ($installer->tableExists('banner')) {
                $connection = $installer->getConnection();
                $connection->addIndex(
                    $installer->getTable('banner'),
                    $setup->getIdxName(
                        $installer->getTable('banner'),
                        ['name'],
                        AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    ['name'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                );
            }

            if ($installer->tableExists('slide')) {
                $connection = $installer->getConnection();
                $connection->addIndex(
                    $installer->getTable('slide'),
                    $setup->getIdxName(
                        $installer->getTable('slide'),
                        ['name', 'url', 'image'],
                        AdapterInterface::INDEX_TYPE_FULLTEXT
                    ),
                    ['name', 'url', 'image'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                );
            }

//            bỏ column banner_id của bảng slide
            if ($installer->tableExists('slide')) {
                $connection = $installer->getConnection();
                $tableName = $installer->getTable('slide');
                $columnName = 'banner_id';
                if ($connection->tableColumnExists($tableName, $columnName, $schemaName = null)) {
                    $connection->dropColumn($tableName, $columnName, $schemaName = null);
                }
            }

//          update banner_id và slide_id của bảng banner_slide
            if ($installer->tableExists('banner_slide')) {
                $connection = $installer->getConnection();
                $tableName = $installer->getTable('banner_slide');
                $banner_id = 'banner_id';

                if ($connection->tableColumnExists($tableName, $banner_id, $schemaName = null)) {
                    $connection->changeColumn(
                        $tableName,
                        $banner_id,
                        $banner_id,
                        ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'unsigned' => true]
                    );
                }

                $slide_id = 'slide_id';
                if ($connection->tableColumnExists($tableName, $slide_id, $schemaName = null)) {
                    $connection->changeColumn(
                        $tableName,
                        $slide_id,
                        $slide_id,
                        ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'unsigned' => true]
                    );
                }

            }

            //            set foreign key của bảng banner slide theo bảng banner và bảng slide
            if ($installer->tableExists('banner_slide')) {
                if ($installer->tableExists('banner')) {
                    $connection = $installer->getConnection();
                    $connection->addForeignKey(
                        $installer->getFkName('banner_slide', 'banner_id', 'banner', 'id'),
                        'banner_slide',
                        'banner_id',
                        'banner',
                        'id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }

                if ($installer->tableExists('slide')) {
                    $connection = $installer->getConnection();
                    $connection->addForeignKey(
                        $installer->getFkName('banner_slide', 'slide_id', 'slide', 'id'),
                        'banner_slide',
                        'slide_id',
                        'slide',
                        'id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }
            }

//            Alter table / Update column.
            if ($installer->tableExists('banner_slide')) {
                $connection = $installer->getConnection();
                if (!$connection->tableColumnExists('banner_slide', 'position')) {
//                phải có cả 3 tham số type,nullable và comment mới chạy được.
                    $connection->addColumn(
                        $installer->getTable('banner_slide'),
                        'position',
                        [
                            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            'nullable' => false,
                            'after' => 'slide_id',
                            'comment' => 'Position'
                        ]
                    );
                }
            }

//        tạo bảng page
            if (!$installer->tableExists('page')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('page')
                )
                    ->addColumn(
                        'id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'ID'
                    )
                    ->addColumn(
                        'page_name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Page Name'
                    )
                    ->addColumn(
                        'page_url',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        ['nullable => false'],
                        'Page URL'
                    )
                    ->addColumn(
                        'created_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                        'Created At'
                    )->addColumn(
                        'updated_at',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        null,
                        ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                        'Updated At')
                    ->setComment('Banner Slide Table');

                $installer->getConnection()->createTable($table);
            }

//          xóa page_url và thay bằng page_id của bảng banner_page
//          truncate table banner_page xong mới tạo column page_id
            if ($installer->tableExists('banner_page')) {
                $connection = $installer->getConnection();
                $tableName = $installer->getTable('banner_page');

                if ($connection->tableColumnExists($tableName, 'page_url', $schemaName = null)) {
//                  truncate table
                    $connection->truncateTable($tableName);
                    $connection->dropColumn($tableName, 'page_url', $schemaName = null);
                }

                $connection->addColumn(
                    $tableName,
                    'page_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => false,
                        'after' => 'banner_id',
                        'comment' => 'Page ID'
                    ]
                );
            }

//            update banner_id và page_id của bảng banner_page
            if ($installer->tableExists('banner_page')) {
                $connection = $installer->getConnection();
                $tableName = $installer->getTable('banner_page');
                $banner_id = 'banner_id';

                if ($connection->tableColumnExists($tableName, $banner_id, $schemaName = null)) {
                    $connection->changeColumn(
                        $tableName,
                        $banner_id,
                        $banner_id,
                        ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'unsigned' => true]
                    );
                }

                $page_id = 'page_id';
                if ($connection->tableColumnExists($tableName, $page_id, $schemaName = null)) {
                    $connection->changeColumn(
                        $tableName,
                        $page_id,
                        $page_id,
                        ['type' => Table::TYPE_INTEGER, 'nullable' => false, 'unsigned' => true]
                    );
                }

            }

//            set foreign key của bảng banner page theo bảng banner và bảng page
            if ($installer->tableExists('banner_page')) {
                if ($installer->tableExists('banner')) {
                    $connection = $installer->getConnection();
                    $connection->addForeignKey(
                        $installer->getFkName('banner_page', 'banner_id', 'banner', 'id'),
                        'banner_page',
                        'banner_id',
                        'banner',
                        'id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }

                if ($installer->tableExists('page')) {
                    $connection = $installer->getConnection();
                    $connection->addForeignKey(
                        $installer->getFkName('banner_page', 'page_id', 'page', 'id'),
                        'banner_page',
                        'page_id',
                        'page',
                        'id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }
            }

            $installer->endSetup();
        }
    }
}
