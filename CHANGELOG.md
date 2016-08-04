# Changelog

All Notable changes to `Slick/Mail` will be documented in this file.

## v1.1.x - 2016-??-??

### Added
- Complete implementation on e-mail Message
- Interfaces for Message, Address, AddressList, MessageBody and MimePart
- Interface for message Transport handler

### Removed
- Zend-Mail message
- Support for PHP <= 5.4

### Fixed
- Support for Slick/Common ^1.2
- Support for Slick/Template ^1.2

### Security
- Forced ext-mcrypt on composer.json 

## v1.0.2       2016-01-06

### Fixed
- E-STRICT warning on the template methods 'body' property definition.

## v1.0.1       2015-01-06

### Fixed
- Fix bug on mime part content generation.

## v1.0.0       2015-01-05

### Added
-  Initial release