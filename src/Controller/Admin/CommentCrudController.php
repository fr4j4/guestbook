<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

	public function configureFields(string $pageName): iterable
	{
		return [
			Field::new('author'),
			Field::new('photoFileName'),
			Field::new('text'),
			DateField::new('createdAt'),
			Field::new('photoFileName'),
			AssociationField::new('conference')
				->autocomplete(),
		];
	}	


	/*
	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id'),
			TextField::new('title'),
			TextEditorField::new('description'),
		];
	}
	 */
}
