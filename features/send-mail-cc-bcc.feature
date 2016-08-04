# send-amil-cc-bcc.feature
  Feature: Send email CC and Bcc
    In order to send an e-mail to recipients in CC and/or BCC
    As a developer
    I want to add cc or bcc address to the message

  Scenario: Send e-mail with CC to other recipient
    Given I create a message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    And I set the message CC "jane.doe@example.com"
    And I set the message body:
    """
    Hello John, nice to have you around!

    Regards,
    """
    When I send the message
    Then the receptor should receive the message
    And the CC receptor should receive the message

  Scenario: Send e-mail with BCC to other recipient
    Given I create a message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    And I set the message BCC "jane.doe@example.com"
    And I set the message body:
    """
    Hello John, nice to have you around!

    Regards,
    """
    When I send the message
    Then the receptor should receive the message
    And the BCC receptor should receive the message

  Scenario: Send e-mail with CC to other recipient
    Given I create a message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    And I set the message CC "jane.doe@example.com"
    And I set the message body:
    """
    Hello John, nice to have you around!

    Regards,
    """
    When I send the message with SMPT
    Then the receptor should receive the message
    And the CC receptor should receive the message