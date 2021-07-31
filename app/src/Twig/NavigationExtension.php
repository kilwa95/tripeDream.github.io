<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Environment;
use App\Entity\Pays;
use App\Entity\Activite;
use App\Entity\Saison;



class NavigationExtension extends AbstractExtension
{

    protected $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    

    public function getFunctions(): array
    {
        return [
            new TwigFunction('menu', [$this, 'displayMenu'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ]),
            new TwigFunction('footer', [$this, 'displayFooter'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ])
        ];
    }

    public function displayMenu(Environment $environment)
    {
        $pays =  $this->doctrine->getRepository(Pays::class)->findAll();
        $activites = $this->doctrine->getRepository(Activite::class)->findAll();
        $saison = $this->doctrine->getRepository(Saison::class)->findAll();
        return $environment->render('Front/navigation/menu.html.twig',[
            'pays' => $pays,
            'activites' =>  $activites,
            'saison' =>  $saison
        ]);
    }

    public function displayFooter(Environment $environment)
    {
        $pays =  $this->doctrine->getRepository(Pays::class)->findAll();
        $activites = $this->doctrine->getRepository(Activite::class)->findAll();
        $saison = $this->doctrine->getRepository(Saison::class)->findAll();
        return $environment->render('Front/navigation/footer.html.twig',[
            'pays' => $pays,
            'activites' =>  $activites,
            'saison' =>  $saison
        ]);
    }
}
