<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pays;


class PaysFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // 226
        $pays = ["Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola", "Anguilla", "Antarctique", "Antigua-et-Barbuda",
                 "Antilles néerlandaises", "Arabie saoudite", "Argentine", "Arménie", "Aruba", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn",
                 "Bangladesh", "Barbade", "Bélarus", "Belgique", "Belize", "Bénin", "Bermudes", "Bhoutan", "Bolivie", "Bosnie-Herzégovine", "Botswana",
                 "Brésil", "Brunéi Darussalam", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge", "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine",
                 "Chypre", "Colombie", "Comores", "Congo", "Corée du nord", "Corée du sud", "Costa Rica", "Côte d’Ivoire", "Croatie", "Cuba", "Danemark",
                 "Djibouti", "Dominique", "Egypte", "El Salvador", "Emirats arabes unis", "Equateur", "Erythrée", "Espagne", "Estonie", "Etats-Unis d’Amérique",
                 "Ethiopie", "Russie", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Géorgie", "Ghana", "Gibraltar", "Grèce", "Groenland",
                 "Guadeloupe", "Guam", "Guatemala", "Guinée", "Guinée équatoriale", "Guinée-Bissau", "Guyana", "Guyane française", "Haïti", "Honduras", "Hong Kong",
                 "Hongrie", "Ile Norfolk", "Iles Cook", "Iles d’Aland", "Iles Falkland", "Iles Féroé", "Iles Mariannes septentrionales",
                 "Iles Marshall", "Iles Salomon", "Iles Svalbard et Jan Mayen", "Iles Turques et Caïques", "Iles Vierges américaines", "Iles Vierges britanniques",
                 "Iles Wallis et Futuna", "Inde", "Indonésie", "Iran", "Iraq", "Irlande", "Islande", "Italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan",
                 "Kenya", "Kirghizistan", "Kiribati", "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Libéria", "Libye", "Liechtenstein", "Lituanie", "Luxembourg",
                 "Macao", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", "Maroc", "Martinique", "Maurice", "Mauritanie", "Mayotte", "Mexique", "Micronésie",
                 "Moldovie", "Monaco", "Mongolie", "Montserrat", "Mozambique", "Myanmar", "Namibie", "Nauru", "Népal", "Nicaragua", "Niger", "Nigéria", "Nioué", "Norvège",
                 "Nouvelle-Calédonie", "Nouvelle-Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palaos", "Palestine", "Panama", "Papouasie-Nouvelle-Guinée",
                 "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pitcairn", "Pologne", "Polynésie française", "Porto Rico", "Portugal", "Qatar",
                 "République démocratique du Congo", "République dominicaine", "République tchèque", "Réunion", "Roumanie", "Royaume-Uni", "Rwanda", "Saint-Kitts-et-Nevis",
                 "Saint-Marin", "Saint-Pierre-et-Miquelon", "Saint-Siège", "Saint-Vincent-et-les Grenadines", "Sainte-Hélène", "Sainte-Lucie", "Samoa", "Samoas américaines",
                 "Sao Tomé-et-Principe", "Sénégal", "Serbie-et-Monténégro", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovénie", "Somalie", "Soudan",
                 "Sri Lanka", "Suède", "Suisse", "Suriname", "Swaziland", "Syrie", "Tadjikistan", "Taiwan", "Tanzanie", "Tchad", "Thaïlande", "Timor-Leste", "Togo",
                 "Tokélaou", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turkménistan", "Turquie", "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Venezuela", "Viet Nam",
                 "Yémen", "Zambie", "Zimbabwe"
        ];
        
        foreach ($pays as $p) {
            $country = new Pays();
            $country->setName($p);
            $manager->persist($country);
        }

        $manager->flush();
    }
}
