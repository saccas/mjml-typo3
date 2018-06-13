<?php
namespace Saccas\Mjml\Tests\Functional\Domain\Renderer;

use Saccas\Mjml\Domain\Renderer\Command;
use Saccas\Mjml\Tests\Unit\AbstractUnitTestCase;
use TYPO3\CMS\Core\Package\Package;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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
    <mj-section>
      <mj-column>
        <mj-image src="/assets/img/easy-and-quick.png" width="112px" />
        <mj-text font-size="20px" color="#595959" align="center">Easy and Quick</mj-text>
      </mj-column>
      <mj-column>
        <mj-image src="/assets/img/responsive.png" width="135px" />
        <mj-text font-size="20px" color="#595959" align="center">Responsive</mj-text>
      </mj-column>
    </mj-section>
    <mj-section>
      <mj-column>
        <mj-button background-color="#F45E43" font-size="15px">Discover</mj-button>
      </mj-column>
    </mj-section>
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
        // Mock extension to be active, to enable path fetching to call node binary.
        $packageMock = $this->getMockBuilder(Package::class)
            ->disableOriginalConstructor()
            ->getMock();
        $packageMock->expects($this->any())
            ->method('getPackagePath')
            ->willReturn(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');
        $packageManagerMock = $this->getMockBuilder(PackageManager::class)->getMock();
        $packageManagerMock->expects($this->any())
            ->method('isPackageActive')
            ->with('mjml')
            ->willReturn(true);
        $packageManagerMock->expects($this->any())
            ->method('getPackage')
            ->with('mjml')
            ->willReturn($packageMock);
        ExtensionManagementUtility::setPackageManager($packageManagerMock);

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mjml'] = serialize([
            'nodeBinaryPath' => 'node',
            'mjmlBinaryPath' => 'node_modules/mjml/bin/',
            'mjmlBinary' => 'mjml',
            'mjmlParams' => '-s',
        ]);

        $subject = $this->objectManager->get(Command::class);
        $html = $subject->getHtmlFromMjml(static::EXAMPLE_MJML_TEMPLATE);
        // remove comment rendered by the outputToConsole https://github.com/mjmlio/mjml/blob/50b08513b7a651c234829abfde254f106a62c859/packages/mjml-cli/src/commands/outputToConsole.js#L4
        $html = preg_replace('/<!-- FILE: (.*)-->/Uis', '', $html);

        $this->assertStringEqualsFile(
            dirname(__FILE__) . '/CommandTestFixture/Expected.html',
            $html,
            'Command renderer did not return expected HTML.'
        );
    }
}
