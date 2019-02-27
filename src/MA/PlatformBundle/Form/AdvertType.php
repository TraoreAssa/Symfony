<?php

namespace MA\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MA\PlatformBundle\Form\ImageType;
use MA\PlatformBundle\Form\CategoryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MA\PlatformBundle\Repository\CategoryRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class AdvertType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {

    // Selection de toute les categories commencant par D
    $pattern = 'D%';

    $builder
      ->add('date',      DateTimeType::class)
      ->add('title',     TextType::class)
      ->add('author',    TextType::class)
      ->add('content',   TextareaType::class)
      ->add('published', CheckboxType::class, array('required' => false))
      ->add('image',     ImageType::class)
      /*
       * Rappel :
       ** - 1er argument : nom du champ, ici « categories », car c'est le nom de l'attribut
       ** - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
       ** - 3e argument : tableau d'options du champ
       */
      ->add('categories', EntityType::class, array(
        'class'   => 'MAPlatformBundle:Category',
        'choice_label'    => 'name',
        'multiple' => true,
        'query_builder' => function(CategoryRepository $repository) use($pattern)
        {
          return $repository->getLikeQueryBuilder($pattern);
        }
      ))
      ->add('save',      SubmitType::class);

      $builder->addEventListener(
        FormEvents::PRE_SET_DATA, // 1er arg l'evt qui nous interesse
        function(FormEvent $event)
        {
          //on recupere l'objet Advert
          $advert = $event->getData();
          if(null === $advert)
          {
            return;
          }
          if(!$advert->getPublished() || null === $advert->getId())
          {
            // alors ajouter le champ published
            $event->getForm()->add('published', CheckboxType::class, array('required'=>false));
          }
          else{
            $event->getForm()->remove('published');
          }
        }
      );
  }
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'MA\PlatformBundle\Entity\Advert'
    ));
  }

}
