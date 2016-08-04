# send-mime-simple-message.feature
  Feature: Send a MIME v1.0 compliant message
    In order to send MIME type messages
    As a developer
    I want a special message object that will encapsulate all necessary headers/body construction

  Scenario: Send an HTML message with mime-type
    Given I create a MIME message
    And I add a mime part with type "text/html":
    """
    <b>Hello John</b>,
    nice to have you around!

    <i>Regards</i>,
    """
    And I set message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    When I send the message
    Then the receptor should receive the message

  Scenario: Send an HTML message with mime-type
    Given I create a MIME message
    And I add a mime part with type "text/html":
    """
    <b>Hello John</b>,
    nice to have you around!

    <i>Regards</i>,
    """
    And I set message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    When I send the message with SMPT
    Then the receptor should receive the message