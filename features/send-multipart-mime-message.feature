# send-multipart-mime-message.feature
  Feature: Send a multipart MIME message with HTML and text versions
    In order to send HTML and text (alternative) e-mail messages
    As a developer
    I want a special message object that allows multipart MIME type composition

  Scenario: Send HTML and alternative text message
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
    And I set message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    When I send the message
    Then the receptor should receive the message