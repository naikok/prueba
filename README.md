# prueba

In order to execute the project, clone the repository and after that make a composer install in the main project's folder in order to install the required dependencies.

In order to run tests coverage:

1) Go to root project folder and run all tests, in this case we have just tested the terminal which is the main command line

phpunit --bootstrap vendor/autoload.php tests

Note: We should have all tests created per each class in order to have full coverage.

2) Notes:

  PersistenService package includes a DataManager class for reading the datasource, I have choosen json format by default,
  however tomorrow we could be using a different datasource such as csv file, database ...

  In order to have more flexibility we have included here an interface and we can use in future a FactoryManagerDataSource as     long as the class the new class created includes the interfae IDataManager

4) In order to check the api go to the src folder included on the project and index will be executed as main command line.
