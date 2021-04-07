<?php

namespace App\Tests\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use App\Form\RegisterType;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmExtension;
use App\Entity\User;

class RegisterTypeTest extends TypeTestCase
{
    
    public function testSubmitRegisterForm()
    {   
        $formData = [
            'email' => 'user@user.com',
            'area' => 'Martinique',
            'firstname' => 'isabella',
            'lastname' => 'swann',
            'password' => 'isabella',
            'nickname' => 'bella'
        ];

        $user = $this->createMock(User::class);
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(RegisterType::class, $user);

        $expected = $this->createMock(User::class);
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $user);

    }
}
