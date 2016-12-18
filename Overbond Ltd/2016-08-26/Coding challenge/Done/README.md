**Install**

The project requires `php: ^5.6` version.
Before running the project use [Composer](https://getcomposer.org/) to download required libraries into project's directory: `php composer.phar install`


**Challenge #1**

Run this line to load the "sample_input1.csv" file and get the result:
`php bond1.php -f "sample_input1.csv"`

If you want to run other file then just change the value of `sample_input1.csv` to the name of your CSV file and make sure the file is placed to the same directory as `bond1.php` file.


**Challenge #2**

Run this line to load the "sample_input2.csv" file and get the result:
`php bond2.php -f "sample_input2.csv"`

If you want to run other file then just change the value of `sample_input2.csv` to the name of your CSV file and make sure the file is placed to the same directory as `bond2.php` file.


**Testing**

`php phpunit-5.5.3.phar`
Two tests for calculations were developed. One for Challenge #1 and one for Challenge #2.



**Reasoning behind technical choices:**

- Made everything with PHP, because this is the technology-language I am most comfortable with at the moment.

- Chosen Composer for managing libraries, because it manages well libraries I need for CSV manipulation and work within CLI environment. 
Alternatives like PEAR are not so good, because: 
1) poor amount of libraries available, 
2) everybody moving from PEAR to Composer which means it is easier for more people to manage Composer today and this will also possibly result to faster understanding of the project for other developers in the case they will join the project.

- `aura/cli` - the package is used for manipulating CLI. Alternatives found in Packagist are not so useful in our case.

- `league/csv` - the package for managing CSV files. Took the most popular one from Packagist, happy with that.

- `phpunit/phpunit` - the package for testing code. This is the standard tool in PHP world.


**Trade-offs I might have made or what I might do differently if I was to spend additional time on the project**

- More object oriented programming (OOP). SPlit to several classes maybe.
- More tests, more accurate tests.
- In some places I used parameters to pass index names (like "type", "term" or "yield"), I would fix that. I personally feel these constants are kind of hard-coding and I would like to avoid this.
- Better user interface, even if that is CLI only. However, I am not so sure where you will use the output-result, but probably for pipes or streams to redirect the result somewhere else, for example: to other program, to API, etc. So maybe the UI isn't even needed, would speak with you about it.
- Would probably use better error handling
- Would optimize some iterations. However, depending on the amounts of data we are dealing with. If this is about playing with several hundreds of lines then it is ok, but if thousands and more then optimization would be good to do.
- I would use any PHP framework if the project is about to be really big. I have not used any frameworks (Symfony, Zend, Laravel, etc.) at the moment, because I think that the program itself is much more faster, cleaner and understandable without frameworks involved at the moment. Having no framework here at the moment is also useful for those who have no experience in one or another PHP framework.
- Would make much more comments on code (phpDoc), would add more information on inputs and outputs of methods.
