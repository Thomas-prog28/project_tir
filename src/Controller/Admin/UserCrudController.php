<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Coach;
use App\Entity\CaMember;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setDefaultSort(['name' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield TextField::new('firstname', 'Prénom');
        yield TextField::new('email', 'Email');
        yield TextField::new('licenceNumberDisplay', 'N° Licence');

        //Affichage en liste/détail (utilise pictureName + uri_prefix Vich)
        yield ImageField::new('pictureName', 'Photo')
            ->setBasePath('uploads/images')
            ->onlyOnIndex();

        //champ d'upload dans le formulaire d'édition (utilise pictureFile, propriété Vich non persistée)
        yield Field::new('pictureFile', 'Photo')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        
        if ($pageName === Crud::PAGE_EDIT) {
            yield FormField::addFieldSet('Statut Coach');
            yield BooleanField::new('coachEnabled', 'Est coach ?')
                ->renderAsSwitch(true);
            yield TextField::new('diplomaNumber', 'N° Diplôme')
                ->setFormTypeOption('required', false);
            yield TextField::new('speciality', 'Spécialité')
                ->setFormTypeOption('required', false);

            yield FormField::addFieldSet('Statut Membre du CA');
            yield BooleanField::new('caMemberEnabled', 'Est membre du CA ?')
                ->renderAsSwitch(true);
            yield TextField::new('position', 'Fonction')
                ->setFormTypeOption('required', false);
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW) // pas de création manuelle, seule l'inscription crée un User
            ->update(Crud::PAGE_INDEX, Action::DELETE, fn (Action $action) => $action->setLabel('Supprimer'))
            ->update(Crud::PAGE_INDEX, Action::EDIT, fn (Action $action) => $action->setLabel('Modifier'));
    }

    //Pré-rempli les champs virtuels avec les valeurs actuelles à l'ouverture du formulaire
    public function edit(AdminContext $context): KeyValueStore|Response
    {
        /** @var User $user */
        $user = $context->getEntity()->getInstance();

        $user->setCoachEnabled($user->isCoach());
        $user->setDiplomaNumber($user->getCoach()?->getDiplomaNumber());
        $user->setSpeciality($user->getCoach()?->getSpeciality());

        $user->setCaMemberEnabled($user->isCaMember());
        $user->setPosition($user->getCaMember()?->getPosition());

        return parent::edit($context);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;

        //Gestion Coach
        if ($user->isCoachEnabled()) {
            $coach = $user->getCoach() ?? new Coach();
            $coach->setUser($user);
            $coach->setDiplomaNumber($user->getDiplomaNumber() ?: null);
            $coach->setSpeciality($user->getSpeciality() ?: null);
            $entityManager->persist($coach);
            $user->setCoach($coach);
        } elseif ($user->getCoach() !== null) {
            $entityManager->remove($user->getCoach());
            $user->setCoach(null);
        }

        //Gestion CaMember
         if ($user->isCaMemberEnabled()) {
            $caMember = $user->getCaMember() ?? new CaMember();
            $caMember->setUser($user);
            $caMember->setPosition($user->getPosition() ?: null);
            $entityManager->persist($caMember);
            $user->setCaMember($caMember);
        } elseif ($user->getCaMember() !== null) {
            $entityManager->remove($user->getCaMember());
            $user->setCaMember(null);
        }

        $entityManager->persist($user);
        $entityManager->flush();
    }
}