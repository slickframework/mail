# send-simple-mail.feature
  Feature: Send simple email.
    In order to send simple e-mail (text) messages
    As a developer
    I will create an e-mail message, a body and send it with a transport agent

  Scenario: Send greetings message
    Given I create a message from "me@example.com" to "john.doe@example.com"
    And I set the message subject "Greetings"
    And I set the message body:
    """
    Hello John, nice to have you around!

    Regards,
    """
    When I send the message
    Then the receptor should receive the message

    Scenario: Send greetings message using SMTP transport
      Given I create a message from "me@example.com" to "john.doe@example.com"
      And I set the message subject "Greetings (SMTP)"
      And I set the message body:
      """
      Hello John, nice to have you around!

      Regards,
      """
      When I send the message with SMPT
      Then the receptor should receive the message