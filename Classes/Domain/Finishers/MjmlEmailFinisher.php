<?php
declare(strict_types=1);
namespace Saccas\Mjml\Domain\Finishers;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;
use TYPO3\CMS\Form\Domain\Model\FormElements\FileUpload;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use TYPO3\CMS\Form\Service\TranslationService;
use TYPO3\CMS\Form\ViewHelpers\RenderRenderableViewHelper;
use Saccas\Mjml\View\MjmlBasedView;

/**
 * This finisher sends an email to one recipient
 *
 * Options:
 *
 * - templatePathAndFilename (mandatory): Template path and filename for the mail body
 * - layoutRootPath: root path for the layouts
 * - partialRootPath: root path for the partials
 * - variables: associative array of variables which are available inside the Fluid template
 *
 * The following options control the mail sending. In all of them, placeholders in the form
 * of {...} are replaced with the corresponding form value; i.e. {email} as recipientAddress
 * makes the recipient address configurable.
 *
 * - subject (mandatory): Subject of the email
 * - recipientAddress (mandatory): Email address of the recipient
 * - recipientName: Human-readable name of the recipient
 * - senderAddress (mandatory): Email address of the sender
 * - senderName: Human-readable name of the sender
 * - replyToAddress: Email address of to be used as reply-to email (use multiple addresses with an array)
 * - carbonCopyAddress: Email address of the copy recipient (use multiple addresses with an array)
 * - blindCarbonCopyAddress: Email address of the blind copy recipient (use multiple addresses with an array)
 * - format: format of the email (one of the FORMAT_* constants). By default mails are sent as HTML
 *
 * Scope: frontend
 */
class MjmlEmailFinisher extends \TYPO3\CMS\Form\Domain\Finishers\EmailFinisher
{
    const FORMAT_PLAINTEXT = 'plaintext';
    const FORMAT_HTML = 'html';

    /**
     * @var array
     */
    protected $defaultOptions = [
        'recipientName' => '',
        'senderName' => '',
        'format' => self::FORMAT_HTML,
        'attachUploads' => true
    ];

    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     *
     * @throws FinisherException
     */
    protected function executeInternal()
    {
        parent::executeInternal();
    }

    /**
     * @param FormRuntime $formRuntime
     * @return StandaloneView
     * @throws FinisherException
     */
    protected function initializeStandaloneView(FormRuntime $formRuntime): StandaloneView
    {
        $format = ucfirst($this->parseOption('format'));
        $standaloneView = $this->objectManager->get(MjmlBasedView::class);

        if (isset($this->options['templatePathAndFilename'])) {
            $this->options['templatePathAndFilename'] = strtr($this->options['templatePathAndFilename'], [
                '{@format}' => $format
            ]);
            $standaloneView->setTemplatePathAndFilename($this->options['templatePathAndFilename']);
        } else {
            if (!isset($this->options['templateName'])) {
                throw new FinisherException('The option "templateName" must be set for the EmailFinisher.', 1327058829);
            }
            $this->options['templateName'] = strtr($this->options['templateName'], [
                '{@format}' => $format
            ]);
            $standaloneView->setTemplate($this->options['templateName']);
        }

        $standaloneView->assign('finisherVariableProvider', $this->finisherContext->getFinisherVariableProvider());

        if (isset($this->options['templateRootPaths']) && is_array($this->options['templateRootPaths'])) {
            $standaloneView->setTemplateRootPaths($this->options['templateRootPaths']);
        }

        if (isset($this->options['partialRootPaths']) && is_array($this->options['partialRootPaths'])) {
            $standaloneView->setPartialRootPaths($this->options['partialRootPaths']);
        }

        if (isset($this->options['layoutRootPaths']) && is_array($this->options['layoutRootPaths'])) {
            $standaloneView->setLayoutRootPaths($this->options['layoutRootPaths']);
        }

        if (isset($this->options['variables'])) {
            $standaloneView->assignMultiple($this->options['variables']);
        }

        $standaloneView->assign('form', $formRuntime);
        $standaloneView->getRenderingContext()
            ->getViewHelperVariableContainer()
            ->addOrUpdate(RenderRenderableViewHelper::class, 'formRuntime', $formRuntime);

        return $standaloneView;
    }
}
