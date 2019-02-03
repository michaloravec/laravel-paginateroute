<?php

namespace MichalOravec\PaginateRoute\Test;

class DashTranslationTest extends TestCase
{
    /**
     * @var string
     */
    protected $locale = 'sk';

    /**
     * @var string
     */
    protected $mode = 'dash';

    /**
     * @test
     */
    public function it_translates_the_page_word()
    {
        $this->registerDefaultRoute();

        $response = $this->callRoute('/strana-2');

        $this->assertNotEmpty($response['models']['data']);
    }

    /**
     * @test
     */
    public function it_doesnt_accept_the_english_word_anymore_when_translated()
    {
        $this->registerDefaultRoute();

        $this->assertEquals(404, $this->call('GET', 'dummies/page-1')->status());
    }
}
