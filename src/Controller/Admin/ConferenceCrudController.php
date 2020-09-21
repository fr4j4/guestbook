<?php

namespace App\Controller\Admin;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;


class ConferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Conference::class;
    }

	public function configureFields(string $pageName): iterable
	{
		return [
			Field::new('city'),
			Field::new('year'),
			Field::new('isInternational'),
			Field::new('commentsCount','Comments')->onlyOnIndex(),
            Field::new('slug')->onlyOnIndex(),
		];
	}	

}
