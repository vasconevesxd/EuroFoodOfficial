<?php

use yii\db\Migration;

/**
 * Class m181210_161141_init_language
 */
class m181210_161141_init_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181210_161141_init_language cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->batchInsert('language', ['name'], [
            ['Afrikanns'],
            ['Albanian'],
            ['Arabic'],
            ['Armenian'],
            ['Basque'],
            ['Bengali'],
            ['Bulgarian'],
            ['Catalan'],
            ['Cambodian'],
            ['Chinese (Mandarin)'],
            ['Croation'],
            ['Czech'],
            ['Danish'],
            ['Dutch'],
            ['English'],
            ['Estonian'],
            ['Fiji'],
            ['Finnish'],
            ['French'],
            ['Georgian'],
            ['German'],
            ['Greek'],
            ['Gujarati'],
            ['Hebrew'],
            ['Hindi'],
            ['Hungarian'],
            ['Icelandic'],
            ['Indonesian'],
            ['Irish'],
            ['Italian'],
            ['Japanese'],
            ['Javanese'],
            ['Korean'],
            ['Latin'],
            ['Latvian'],
            ['Lithuanian'],
            ['Macedonian'],
            ['Malay'],
            ['Malayalam'],
            ['Maltese'],
            ['Maori'],
            ['Marathi'],
            ['Mongolian'],
            ['Nepali'],
            ['Norwegian'],
            ['Persian'],
            ['Polish'],
            ['Portuguese'],
            ['Punjabi'],
            ['Quechua'],
            ['Romanian'],
            ['Russian'],
            ['Samoan'],
            ['Serbian'],
            ['Slovak'],
            ['Slovenian'],
            ['Spanish'],
            ['Swahili'],
            ['Swedish'],
            ['Tamil'],
            ['Tatar'],
            ['Telugu'],
            ['Thai'],
            ['Punjabi'],
            ['Tonga'],
            ['Turkish'],
            ['Ukranian'],
            ['Urdu'],
            ['Uzbek'],
            ['Vietnamese'],
            ['Welsh'],
            ['Xhosa'],
        ]);
    }

    public function down()
    {
        $this->dropTable('language');
    }
}
