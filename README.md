# MJML

https://mjml.io integration for **TYPO3 EXT:Form**

MJML is a markup language designed to reduce the pain of coding a responsive email. Its semantic syntax makes it easy and straightforward and its rich standard components library speeds up your development time and lightens your email codebase. MJML’s open-source engine generates high quality responsive HTML compliant with best practices. https://mjml.io/getting-started-onboard

## Installation

### Over composer:

`composer require saccas/mjml`

### NPM

Npm is needed for the conversion of the MJML file to HTML

## Usage in EXT:Form

You can overwrite the default _finishersEmailMixin_ so that he uses the _MjmlEmailFinisher_
or create your own.

```
TYPO3:
  CMS:
    Form:
      mixins:
        finishersEmailMixin:
          implementationClassName: 'Saccas\Mjml\Domain\Finishers\MjmlEmailFinisher'
```

## MJML Documentation

https://mjml.io/documentation/

## Usage in your distribution

To automate the installation of the npm packages, you could add the following lines to your composer.json

```
	"scripts": {
		"post-install-cmd": [
			"cd vendor/saccas/mjml && npm prune --production"
		],
		"post-update-cmd": [
			"cd vendor/saccas/mjml && npm prune --production"
		],
		"pre-deploy": [
			"cd vendor/saccas/mjml && npm prune --production"
		]
	}
```
