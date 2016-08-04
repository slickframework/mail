# send-mail-with-attachments.feature
  Feature: Send messages with attachments
    In order to send attachments in e-mail messages
    As a developer
    I want to have a special message object that allows multipart MIME
    file handling

  Scenario: Send an email with attachments
    Given I create a MIME message
    And I add a mime part with type "text/html":
    """
    <b>Hello John</b>,
    nice to have you around!

    <i>Regards</i>,
    """
    And I add a mime part with type "text/plain":
    """
    Hello John,
    nice to have you around!

    Regards,
    """
    And I set file "example.pdf" to be attached
    And I set message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    When I send the message
    Then the receptor should receive the message

  Scenario: Send an email with attachments
    Given I create a MIME message
    And I add a mime part with type "text/html":
    """
    <b>Hello John</b>,
    nice to have you around!

    <i>Regards</i>,
    """
    And I add a mime part with type "text/plain":
    """
    Hello John,
    nice to have you around!

    Regards,
    """
    And I set file "example.pdf" to be attached
    And I set message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings (SMTP)"
    When I send the message with SMPT
    Then the receptor should receive the message