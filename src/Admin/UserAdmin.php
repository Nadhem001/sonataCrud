<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
final class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('username', TextType::class); 
        $form->add('password', RepeatedType::class,[
            'type' => PasswordType::class,
        ]); 
        
    }
    
    protected function configurePersistentParameters(): array
    {
        if (!$this->getRequest()) {
            return [];
        }
        
        return [
            'provider' => $this->getRequest()->get('provider'),
            'context'  => $this->getRequest()->get('context', 'default'),
        ];
    }
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('username');
        $datagrid->add('password');
    }

    protected function configureListFields(ListMapper $list): void
    {
        
        $list->addIdentifier('username');
        $list->addIdentifier('password');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('username');
        $show->add('password');
    }
}