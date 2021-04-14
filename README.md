# 2021-frameworks-test2-starter-project

This is the starter project for the online Test 2
(it would also be a good starter project for your project ...)

Here are the steps used to create the project (all from my Symfony PDF book)

Steps for creating Symfony project with PHP unit

------------------------------------------
1 - create new full web Symfony project folder from scratch
------------------------------------------


```
symfony new test2e --full
```


------------------------------------------
2 - Codeception & bits
------------------------------------------

(2-1)
add Codeception

```
composer require --dev codeception/codeception
```

NOTE: 
- say YES to running recipe from contrib 
- do NOT replace PHPUNit with the Symfony bridge - it will means lots of deprecation errors

IGNORE any deprecation notices about PSR-4 namspaces  in _support folders

(2-2)
Add Codeception & MarkupValidator
- asking for markup validator will automatically required basic codceception 

```
composer require --dev kolyunya/codeception-markup-validator
```

(2-3)
add assert throws to Codeception - so we can test for exceptions being thrown

```
composer require  --dev codeception/assert-throws
```


(2-4)
add Codeception symfony modules

```
composer require  --dev codeception/module-symfony codeception/module-doctrine2 codeception/module-asserts codeception/module-rest codeception/module-webdriver 
```





(2-5)
edit your acceptance.suite.yml to look like this
(you are adding the lines starting with `- Symfony:`)

```
actor: AcceptanceTester
modules:
    enabled:
        - PhpBrowser:
            url: http://localhost:8000
        - \App\Tests\Helper\Acceptance
        - Kolyunya\Codeception\Module\MarkupValidator
        - Symfony:
            app_path: 'src'
            environment: 'test'
        - Doctrine2:
            depends: Symfony
            cleanup: true
        - Asserts
```
        
   
   
        
------------------------------------------
3 - add security 
------------------------------------------
See Chapter 19 if Symfony book PDF


(3-1)
Add the security bundle:

```
composer req symfony/security-bundle
```

(3-2)
Add the fixtures bundle (we’ll need this later):

```
composer require  --dev orm-fixtures
```

(3-3)
Create a special security `User` entity

```
php bin/console make:user
```
(accept all the defaults by pressing RETURN)

(3-4)
create a login form and path

```
php bin/console make:auth
```
choose:
Option 1: Login form authenticator

give it the name:
```
LoginFormAuthenticator
```

(then accept all the defaults by pressing RETURN)

(3-5)
allow any user (logged or not) to be able to view the login form
edit file: `/config/packages/security.yml`


add a new final line (removing any green comment lines starting with #) as follows - immediately after the "access_control" line

```
    access_control:
        - { path: ^/login$, roles: IS_AUTHENTICATED_ANONYMOUSLY }
```

NOTE - indentation is important in `.yml` files - the new line should be 4 spaces indented from `access_control`

(3-6) 
add a role hierarchy
edit file: /config/packages/security.yml

add 4 lines (including BLANK LINE before existing `encoders`, - insert these immediately after the first line as follows

```
security:
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN
```
            

------------------------------------------
4 - simplify User->role(s) - avoid JSON string DB storage 
------------------------------------------

see chapter 26 - removing array of roles from User class

(4-1)
add a new String `role` property to the User entity

HINT: use `make:crud User` and add the new property

(4-2)
change the `getRoles()` method to simply return the string role wrapped in an array:

```
/**
 * @see UserInterface
 */
public function getRoles(): array 
{
	return [$this->role]; 
}
```

(4-3)
From `User` entity delete:

- property `$roles` property
- method `setRoles(...)`


------------------------------------------
5 - Create User fixtures
------------------------------------------

(5-1)
create `UserFixtures` class

```
php bin/console make:fixture UserFixtures
```

(5-2)
Add the follow two `use` statements to your new `UserFixtures` class

```
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; 
use App\Entity\User;
```

(5-3)
Add a `$passwordEncoder` property to class `UserFixtures`, and have it intialised by the constructor
(we need this, so we can hash passwords when our User fixture objects are being created and added to the DB)

```
private $passwordEncoder;

public function __construct(UserPasswordEncoderInterface $passwordEncoder) 
{
	$this->passwordEncoder = $passwordEncoder; 
}
```

(5-4)

add a `createUser(...)` method to class `UserFixtures`

```
private function createUser($username, $plainPassword, $role = 'ROLE_USER'):User 
{
	$user = new User(); 
	$user->setEmail($username); 
	$user->setRole($role);
	
	// password - and encoding
	$encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword); 
	$user->setPassword($encodedPassword);
	return $user;
}
```

(5-5)
we can now write code for the `load(...)` method to actually create some `User` objects and persist them in the DB

```
public function load(ObjectManager $manager) 
{
	// create objects
	$userUser = $this->createUser('user@user.com', 'user');
	$userMatt = $this->createUser('matt.smith@smith.com', 'smith', 'ROLE_ADMIN');

	// add to DB queue
	$manager->persist($userUser); 
	$manager->persist($userMatt);

	// send query to DB
	$manager->flush(); 
}
```


------------------------------------------
6 - create migration & generate Admin crud
------------------------------------------

do the usual 

- set DB credentials in .env
- create DB

```
	do:da:cr
```

- create and run a migration

```
	make:mi
	do:mi:mi
```

- load fixtures

```
	do:fi:lo
```
	
- general CRUD for `User` entity

```
	make:crud User
```



------------------------------------------
7 - add password encoder for NEW/EDIT User password
------------------------------------------

chapter 26.4 - we need password encoder for `UserController` class

(7-1)
add `use` statement for class `UserController`

```
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
```

(7-2)
add password encoder parameter for `new(...)` method arguments

```
public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
```

(7-3)
add lines to get plain password, and created encoded password, before persisting `User` record into DB

```
if ($form->isSubmitted() && $form->isValid()) {
	$entityManager = $this->getDoctrine()->getManager();

	// encode password
	$plainPassword = $user->getPassword();
	$encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
	$user->setPassword($encodedPassword);

	$entityManager->persist($user);
	$entityManager->flush();

	return $this->redirectToRoute('user_index');
}
```
        
(7-4)
do same as previous step for the `edit(...)` method

        


------------------------------------------
OPTIONAL: 
------------------------------------------
Make role an entity and relate to it ...


NOTE: Improving security - option steps

- you should look at section 21.6: Path for successful login ...

- chapter 22: customer access denied exception handler
