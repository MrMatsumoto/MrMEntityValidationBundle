MrMEntityValidationBundle
=========================

A Service to check Symfony 2 validations in Doctrine Lifecycle automatically.

It catches the Doctrine prePersist and preUpdate events and applies the validations. On Error a ValidationException.
