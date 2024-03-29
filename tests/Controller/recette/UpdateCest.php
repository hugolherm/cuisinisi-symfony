<?php

namespace App\Tests\Controller\recette;

use App\Factory\EtapeFactory;
use App\Factory\IngredientFactory;
use App\Factory\PaysFactory;
use App\Factory\QuantiteFactory;
use App\Factory\RecetteFactory;
use App\Factory\TypeRecetteFactory;
use App\Factory\UserFactory;
use App\Factory\UstensileFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function testStructurePage1(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        // Page 1
        $I->amOnPage('/recette/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle("Modification de la recette suivante: {$recette->getNomRec()}");
        $I->see("Modification de la recette suivante: {$recette->getNomRec()}", 'h1');
        $I->see('Nom de la recette', 'label');
        $I->see('Description de la recette', 'label');
        $I->see('Image de la recette', 'label');
        $I->see('Temps de préparation', 'label');
        $I->see('Temps de cuisson', 'label');
        $I->see('Nombre de personne(s)', 'label');
        $I->see('Type de la recette', 'label');
        $I->see("Pays d'origine", 'label');
        $I->see('Créer un nouveau pays', 'a[href]');
        $I->see('Ustensiles', 'legend');
        $I->see('Créer un nouvel ustensile', 'a[href]');
        $I->see('Ingredients', 'legend');
        $I->see('Créer un nouvel ingrédient', 'a[href]');
        $I->see("Nombre d'étapes", 'label');
        $I->seeElement('input[type="submit"]');
    }

    public function testSubmitFormPage1(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 3,
        ], 'input[type="submit"]');

        $I->seeCurrentRouteIs('app_recette_updateQte');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testStructurePage2(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 3,
        ], 'input[type="submit"]');

        $I->seeInTitle('Ajout des quantités pour les ingrédients');
        $I->see('Ajout des quantités pour les ingrédients', 'h1');

        $I->see('IngredientTest2', 'h2');
        $I->see('Quantité', 'label');
        $I->see('Unité de mesure', 'label');

        $I->see('IngredientTest3', 'h2');
        $I->see('Quantité', 'label');
        $I->see('Unité de mesure', 'label');
    }

    public function testSubmitFormPage2(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 3,
        ], 'input[type="submit"]');

        $I->submitForm('form[name="quantite"]', [
            'quantite[quantiteIng2]' => 200,
            'quantite[unitMesureIng2]' => 'cl',
            'quantite[quantiteIng3]' => 200,
            'quantite[unitMesureIng3]' => 'g',
        ], 'input[type="submit"]');

        $I->seeCurrentRouteIs('app_recette_updateEtp');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testStructurePage3(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 3,
        ], 'input[type="submit"]');

        $I->submitForm('form[name="quantite"]', [
            'quantite[quantiteIng2]' => 200,
            'quantite[unitMesureIng2]' => 'cl',
            'quantite[quantiteIng3]' => 200,
            'quantite[unitMesureIng3]' => 'g',
        ], 'input[type="submit"]');

        $I->seeInTitle('Ajout des etapes de la recette');
        $I->see('Ajout des etapes de la recette', 'h1');

        $I->seeNumberOfElements('div.mb-3', 3);
        $etapes = $I->grabMultiple('div.mb-3 label');
        $I->assertEquals($etapes, ['Etape 1', 'Etape 2', 'Etape 3']);
    }

    public function testSubmitFormPage3(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2'], ['recette' => $recette, 'numEtape' => 3, 'descEtape' => 'DescTest3']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 2,
        ], 'input[type="submit"]');

        $I->submitForm('form[name="quantite"]', [
            'quantite[quantiteIng2]' => 200,
            'quantite[unitMesureIng2]' => 'cl',
            'quantite[quantiteIng3]' => 200,
            'quantite[unitMesureIng3]' => 'g',
        ], 'input[type="submit"]');

        $I->submitForm('form[name="etape"]', [
            'etape[descEtape1]' => 'DescriptionTest1',
            'etape[descEtape2]' => 'DescriptionTest2',
        ], 'input[type="submit"]');

        $I->seeCurrentRouteIs('app_recette_show', ['id' => 1]);
        $I->seeElement("img[alt='Image de Recette Test Modifiee']");
        $I->see('Recette Test Modifiee', 'h1');
        $I->see('Description Test Modifiee', 'div');
        $I->see('Temps de préparation: 60 min', 'span');
        $I->see('Temps de cuisson: 60 min', 'span');
        $I->see('Ingredients', 'h2');
        $I->seeNumberOfElements('.ingredient ul li', 2);
        $I->see('200 cl IngredientTest2');
        $I->see('200 g IngredientTest3');
        $I->seeNumberOfElements('p', 2);
        $numEtapes = $I->grabMultiple('h3');
        $I->assertEquals($numEtapes, ['Etape 1', 'Etape 2']);
        $descEtapes = $I->grabMultiple('p');
        $I->assertEquals($descEtapes, ['DescriptionTest1', 'DescriptionTest2']);
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I): void
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2'], ['recette' => $recette, 'numEtape' => 3, 'descEtape' => 'DescTest3']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/recette/1/update');
        $I->seeResponseCodeIs(403);
    }
}
