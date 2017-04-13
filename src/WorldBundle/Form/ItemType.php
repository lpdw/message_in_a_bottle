<?php
namespace WorldBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use WorldBundle\Repository\ArticleRepository;
use Doctrine\ORM\EntityRepository;
class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description'
            ])
            ->add('image', FileType::class, array('label' => 'Image'))
            ->add('submit', SubmitType::class)
        ;
    }
}