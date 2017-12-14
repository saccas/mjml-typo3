<?php
namespace Saccas\Mjml\Tests\Functional\Domain\Renderer;

use Saccas\Mjml\Domain\Renderer\Command;
use Saccas\Mjml\Tests\Unit\AbstractUnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class CommandTest extends AbstractUnitTestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public const EXAMPLE_MJML_TEMPLATE = '<mjml>
  <mj-body>
    <mj-container>
      <mj-section>
        <mj-column>
          <mj-image src="/assets/img/easy-and-quick.png" width="112" />
          <mj-text font-size="20px" color="#595959" align="center">Easy and Quick</mj-text>
        </mj-column>
        <mj-column>
          <mj-image src="/assets/img/responsive.png" width="135" />
          <mj-text font-size="20px" color="#595959" align="center">Responsive</mj-text>
        </mj-column>
      </mj-section>
      <mj-section>
        <mj-column>
          <mj-button background-color="#F45E43" font-size="15px">Discover</mj-button>
        </mj-column>
      </mj-section>
    </mj-container>
  </mj-body>
</mjml>
';

    public function setUp()
    {
        parent::setUp();
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * @test
     */
    public function htmlIsReturnedForMjml()
    {
        $expectedHtml = '<!doctype html><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><title></title><!--[if !mso]><!-- --><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">#outlook a{padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.ExternalClass *{line-height:100%}body{margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0}img{border:0;height:auto;line-height:100%;outline:0;text-decoration:none;-ms-interpolation-mode:bicubic}p{display:block;margin:13px 0}</style><!--[if !mso]><!--><style type="text/css">@media only screen and (max-width:480px){@-ms-viewport{width:320px}@viewport{width:320px}}</style><!--<![endif]--><!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]--><!--[if lte mso 11]><style type="text/css">  .outlook-group-fix {    width:100% !important;  }</style><![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px){.mj-column-per-50{width:50%!important}.mj-column-per-100{width:100%!important}}</style></head><body><div class="mj-container"><!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">        <tr>          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">      <![endif]--><div style="margin:0 auto;max-width:600px"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0;width:100%" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0;padding:20px 0"><!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:300px;">      <![endif]--><div class="mj-column-per-50 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0;padding:10px 25px" align="center"><table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0" align="center" border="0"><tbody><tr><td style="width:112px"><img alt="" height="auto" src="/assets/img/easy-and-quick.png" style="border:none;border-radius:0;display:block;font-size:13px;outline:0;text-decoration:none;width:100%;height:auto" width="112"></td></tr></tbody></table></td></tr><tr><td style="word-wrap:break-word;font-size:0;padding:10px 25px" align="center"><div style="cursor:auto;color:#595959;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:20px;line-height:22px;text-align:center">Easy and Quick</div></td></tr></tbody></table></div><!--[if mso | IE]>      </td><td style="vertical-align:top;width:300px;">      <![endif]--><div class="mj-column-per-50 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0;padding:10px 25px" align="center"><table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0" align="center" border="0"><tbody><tr><td style="width:135px"><img alt="" height="auto" src="/assets/img/responsive.png" style="border:none;border-radius:0;display:block;font-size:13px;outline:0;text-decoration:none;width:100%;height:auto" width="135"></td></tr></tbody></table></td></tr><tr><td style="word-wrap:break-word;font-size:0;padding:10px 25px" align="center"><div style="cursor:auto;color:#595959;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:20px;line-height:22px;text-align:center">Responsive</div></td></tr></tbody></table></div><!--[if mso | IE]>      </td></tr></table>      <![endif]--></td></tr></tbody></table></div><!--[if mso | IE]>      </td></tr></table>      <![endif]--><!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">        <tr>          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">      <![endif]--><div style="margin:0 auto;max-width:600px"><table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0;width:100%" align="center" border="0"><tbody><tr><td style="text-align:center;vertical-align:top;direction:ltr;font-size:0;padding:20px 0"><!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:600px;">      <![endif]--><div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%"><table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr><td style="word-wrap:break-word;font-size:0;padding:10px 25px" align="center"><table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate" align="center" border="0"><tbody><tr><td style="border:none;border-radius:3px;color:#fff;cursor:auto;padding:10px 25px" align="center" valign="middle" bgcolor="#F45E43"><p style="text-decoration:none;background:#f45e43;color:#fff;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:15px;font-weight:400;line-height:120%;text-transform:none;margin:0">Discover</p></td></tr></tbody></table></td></tr></tbody></table></div><!--[if mso | IE]>      </td></tr></table>      <![endif]--></td></tr></tbody></table></div><!--[if mso | IE]>      </td></tr></table>      <![endif]--></div></body></html>';
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mjml'] = serialize([
            'nodeBinaryPath' => 'node',
            'mjmlBinaryPath' => 'node_modules/.bin/',
            'mjmlBinary' => 'mjml',
            'mjmlParams' => '-s -m',
        ]);

        $subject = $this->objectManager->get(Command::class);
        $html = $subject->getHtmlFromMjml(static::EXAMPLE_MJML_TEMPLATE);
        $this->assertSame(
            $expectedHtml,
            $html,
            'Command renderer did not return expected HTML.'
        );
    }
}
