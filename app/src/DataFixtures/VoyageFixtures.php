<?php

namespace App\DataFixtures;

use App\Entity\Programme;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Voyage;
use App\Entity\InfoPratique;
use App\Entity\Activite;
use App\Entity\Pays;
use App\Entity\Saison;
use App\Entity\Ville;

class VoyageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        $users = $manager->getRepository(User::class)->findAll();
        $usersAgencies = [];
        
        $images = ["afghanistan.jpeg", "afrique_du_sud.jpeg", "albanie.jpeg", "algerie.jpeg", "allemagne.jpeg", "andorre.jpeg", "angola.jpeg", "anguilla.jpeg", "antarctique.jpeg", "antigua-et-barbuda.jpeg",
                   "antilles_neerlandaises.jpeg", "arabie_saoudite.jpeg", "argentine.jpeg", "armenie.jpeg", "aruba.jpeg", "australie.jpeg", "autriche.jpeg", "azerbaidjan.jpeg", "bahamas.jpeg", "bahrein.jpeg",
                   "bangladesh.jpeg", "barbade.jpeg", "belarus.jpeg", "belgique.jpeg", "belize.jpeg", "benin.jpeg", "bermudes.jpeg", "bhoutan.jpeg", "bolivie.jpeg", "bosnie-herzegovine.jpeg", "botswana.jpeg",
                   "bresil.jpeg", "brunei_darussalam.jpeg", "bulgarie.jpeg", "burkina_faso.jpeg", "burundi.jpeg", "cambodge.jpeg", "cameroun.jpeg", "canada.jpeg", "cap-vert.jpeg", "chili.jpeg", "chine.jpeg",
                   "chypre.jpeg", "colombie.jpeg", "comores.jpeg", "congo.jpeg", "coree_du_nord.jpeg", "coree_du_sud.jpeg", "costa_rica.jpeg", "cote_d_ivoire.jpeg", "croatie.jpeg", "cuba.jpeg", "danemark.jpeg",
                   "djibouti.jpeg", "dominique.jpeg", "egypte.jpeg", "el_salvador.jpeg", "emirats_arabes_unis.jpeg", "equateur.jpeg", "erythree.jpeg", "espagne.jpeg", "estonie.jpeg", "etats-unis_d_amerique.jpeg",
                   "ethiopie.jpeg", "russie.jpeg", "fidji.jpeg", "finlande.jpeg", "france.jpeg", "gabon.jpeg", "gambie.jpeg", "georgie.jpeg", "ghana.jpeg", "gibraltar.jpeg", "grece.jpeg", "groenland.jpeg",
                   "guadeloupe.jpeg", "guam.jpeg", "guatemala.jpeg", "guinee.jpeg", "guinee_equatoriale.jpeg", "guinee-bissau.jpeg", "guyana.jpeg", "guyane_francaise.jpeg", "haiti.jpeg", "honduras.jpeg", "hong_kong.jpeg",
                   "hongrie.jpeg", "ile_norfolk.jpeg", "iles_cook.jpeg", "iles_d_aland.jpeg", "iles_falkland.jpeg", "iles_feroe.jpeg", "iles_mariannes_septentrionales.jpeg",
                   "iles_marshall.jpeg", "iles_salomon.jpeg", "iles_svalbard_et_jan_mayen.jpeg", "iles_turques_et_caiques.jpeg", "iles_vierges_americaines.jpeg", "iles_vierges_britanniques.jpeg",
                   "iles_wallis_et_futuna.jpeg", "inde.jpeg", "indonesie.jpeg", "iran.jpeg", "iraq.jpeg", "irlande.jpeg", "islande.jpeg", "italie.jpeg", "jamaique.jpeg", "japon.jpeg", "jordanie.jpeg", "kazakhstan.jpeg",
                   "kenya.jpeg", "kirghizistan.jpeg", "kiribati.jpeg", "koweit.jpeg", "laos.jpeg", "lesotho.jpeg", "lettonie.jpeg", "liban.jpeg", "liberia.jpeg", "libye.jpeg", "liechtenstein.jpeg", "lituanie.jpeg", "luxembourg.jpeg",
                   "macao.jpeg", "madagascar.jpeg", "malaisie.jpeg", "malawi.jpeg", "maldives.jpeg", "mali.jpeg", "malte.jpeg", "maroc.jpeg", "martinique.jpeg", "maurice.jpeg", "mauritanie.jpeg", "mayotte.jpeg", "mexique.jpeg", "micronesie.jpeg",
                   "moldovie.jpeg", "monaco.jpeg", "mongolie.jpeg", "montserrat.jpeg", "mozambique.jpeg", "myanmar.jpeg", "namibie.jpeg", "nauru.jpeg", "nepal.jpeg", "nicaragua.jpeg", "niger.jpeg", "nigeria.jpeg", "nioue.jpeg", "norvege.jpeg",
                   "nouvelle-caledonie.jpeg", "nouvelle-zelande.jpeg", "oman.jpeg", "ouganda.jpeg", "ouzbekistan.jpeg", "pakistan.jpeg", "palaos.jpeg", "palestine.jpeg", "panama.jpeg", "papouasie-nouvelle-guinee.jpeg",
                   "paraguay.jpeg", "pays-bas.jpeg", "perou.jpeg", "philippines.jpeg", "pitcairn.jpeg", "pologne.jpeg", "polynesie_francaise.jpeg", "porto_rico.jpeg", "portugal.jpeg", "qatar.jpeg",
                   "republique_democratique_du_congo.jpeg", "republique_dominicaine.jpeg", "republique_tcheque.jpeg", "reunion.jpeg", "roumanie.jpeg", "royaume-uni.jpeg", "rwanda.jpeg", "saint-kitts-et-nevis.jpeg",
                   "saint-marin.jpeg", "saint-pierre-et-miquelon.jpeg", "saint-siege.jpeg", "saint-vincent-et-les_grenadines.jpeg", "sainte-helene.jpeg", "sainte-lucie.jpeg", "samoa.jpeg", "samoas_americaines.jpeg",
                   "sao_tome-et-principe.jpeg", "senegal.jpeg", "serbie-et-montenegro.jpeg", "seychelles.jpeg", "sierra_leone.jpeg", "singapour.jpeg", "slovaquie.jpeg", "slovenie.jpeg", "somalie.jpeg", "soudan.jpeg",
                   "sri_lanka.jpeg", "suede.jpeg", "suisse.jpeg", "suriname.jpeg", "swaziland.jpeg", "syrie.jpeg", "tadjikistan.jpeg", "taiwan.jpeg", "tanzanie.jpeg", "tchad.jpeg", "thailande.jpeg", "timor-leste.jpeg", "togo.jpeg",
                   "tokelaou.jpeg", "tonga.jpeg", "trinite-et-tobago.jpeg", "tunisie.jpeg", "turkmenistan.jpeg", "turquie.jpeg", "tuvalu.jpeg", "ukraine.jpeg", "uruguay.jpeg", "vanuatu.jpeg", "venezuela.jpeg", "viet_nam.jpeg",
                   "yemen.jpeg", "zambie.jpeg", "zimbabwe.jpeg"
        ];

        foreach ($users as $user) {
            if ($user->getRoles() === ['ROLE_AGENCE'])
                array_push($usersAgencies, $user);
        }

        $infosPratiques = $manager->getRepository(InfoPratique::class)->findAll();
        $activites = $manager->getRepository(Activite::class)->findAll();
        $pays = $manager->getRepository(Pays::class)->findAll();
        $saison = $manager->getRepository(Saison::class)->findAll();
        $villes = $manager->getRepository(Ville::class)->findAll();

        $NB_TRIPS = 226;
        for ($i = 0, $prInd = 0; $i < $NB_TRIPS; $i++, $prInd += 7) {
            $voyage  = new Voyage();
            $voyage->setUser($usersAgencies[array_rand($usersAgencies)]);
            $voyage->setName($faker->jobTitle());
            $voyage->setInfoPratique($infosPratiques[$i]);
            $voyage->setDescription($faker->realText());
            $voyage->setPointFort($faker->realText());
            $voyage->addActivity($activites[array_rand($activites)]);
            $voyage->addPay($pays[$i]);
            $voyage->addSaison($saison[array_rand($saison)]);
            $voyage->addVille($villes[array_rand($villes)]);
            // $voyage->setImageName($images[array_rand($images)]);
            $voyage->setImageName($images[$i]);
            $voyage->setImageSize(12345);
            $voyage->setStatus("avaible");
            $manager->persist($voyage);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            InfoPratiqueFixtures::class,
            ActivityFixtures::class,
            PaysFixtures::class,
            SaisonFixtures::class,
            VilleFixtures::class,
        ];
    }
}