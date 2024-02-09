<?php

namespace App\Controller;

use App\Entity\Inventory\Category;
use App\Entity\Inventory\Item;
use App\Entity\Player;
use App\Entity\PNJ;
use App\Service\CustomSerializer;
use App\Service\FightSetter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api')]
#[IsGranted("IS_AUTHENTICATED_FULLY")]
class ApiController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/game')]
    public function getGame(CustomSerializer $serializer): Response
    {
        return new Response($serializer->serialize($this->getUser()->getGame()));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/player/{player}')]
    public function getPlayer(Player $player, CustomSerializer $serializer): Response
    {
        return new Response($serializer->serialize($player));
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/pnj/{pnj}')]
    public function getPNJ(PNJ $pnj, CustomSerializer $serializer): Response
    {
        return new Response($serializer->serialize($pnj));
    }

    #[Route('/updateEntityStat/{entity}/{stat}/{id}/{value}')]
    public function updatePlayerStat (
        string $entity,
        string $stat,
        int $id,
        int $value,
        EntityManagerInterface $em,
        CustomSerializer $serializer
    ): Response
    {
        $entity = $em->getRepository('App\\Entity\\' . $entity)->find($id);

        $entity->{'set' . $stat}($entity->{'get' . $stat}() + $value);
        if ($entity->{'get' . $stat}() > $entity->{'get' . $stat . 'M'}()) {
            $entity->{'set' . $stat}($entity->{'get' . $stat . 'M'}());
        }
        $em->flush();
        return $this->json($entity->{'get' . $stat}());
    }

    #[Route("/switchPlaying/{type}/{entity}")]
    public function switchPlaying(string $type, int $entity, FightSetter $fightSetter): Response
    {
        $fightSetter->setPlaying($type, $entity);
        return $this->json(true);
    }

    #[Route("/switchFighting/{type}/{entity}")]
    public function switchFighting(string $type, int $entity, FightSetter $fightSetter): Response
    {
        return $this->json($fightSetter->toggleFighting($type, $entity));
    }

    #[Route('/category/create/{name}')]
    public function createCategory(string $name, EntityManagerInterface $em, CustomSerializer $serializer): Response
    {
        $category = new Category($name);
        $category->setInventory($this->getUser()->getGame()->getInventory());
        $em->persist($category);
        $em->flush();
        return $this->json($serializer->serialize($category));
    }

    #[Route('/category/delete/{category}')]
    public function deleteCategory(Category $category, EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();
        return $this->json(true);
    }

    #[Route('/category/update/{category}/{name}')]
    public function updateCategory(Category $category, string $name, EntityManagerInterface $em): Response
    {
        $category->setName($name);
        $em->persist($category);
        $em->flush();
        return $this->json(true);
    }

    #[Route('/item/create/{name}/{category}')]
    public function createItem(string $name, Category $category, EntityManagerInterface $em, CustomSerializer $serializer): Response
    {
        $item = new Item($name);
        $item->setCategory($category);
        $em->persist($item);
        $em->flush();
        return $this->json($serializer->serialize($item));
    }

    #[Route('/item/delete/{item}')]
    public function deleteItem(Item $item, EntityManagerInterface $em): Response
    {
        $em->remove($item);
        $em->flush();
        return $this->json(true);
    }

    #[Route('/item/update/{item}/{name}/{count}')]
    public function updateItem(Item $item, string $name, int $count, EntityManagerInterface $em): Response
    {
        $item->setName($name);
        $item->setCount($count);
        $em->persist($item);
        $em->flush();
        return $this->json(true);
    }
}