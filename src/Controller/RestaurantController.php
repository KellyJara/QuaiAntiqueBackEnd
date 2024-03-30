<?php
namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

#[Route('api/restaurant', name:'app_api_restaurant_')]
class RestaurantController extends AbstractController
{
   public function __construct(
    private EntityManagerInterface $manager, 
    private RestaurantRepository $repository
    ){
    }

    #[Route(name:'new',methods:'POST')]
    public function new():JsonResponse
    {
        $restaurant = new Restaurant();
        $restaurant->setName(name: 'Quai Antique');  
        $restaurant->setDescription(description: 'Quai Antique, tres bon restaurant');  
        $restaurant->setCreatedAt(new \DateTimeImmutable());  
        $restaurant->setMaxGuest(maxGuest:40); 

        //A stocker en base de donées
        $this->manager->persist($restaurant);
        $this->manager->flush();

        return $this->json(
                        ['message' => "Restaurant resource created with {$restaurant->getId()} id"],
                        Response::HTTP_CREATED,
        );
    }

    #[Route('/{id}',name: 'show', methods:'GET')]
    public function show(int $id):JsonResponse
    {
        //$restaurant = CHERCHER RESTAURANT ID=1
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        if (!$restaurant) {
            throw new \Exception("No Restaurant found for {$id} id");
        }

        return $this->json(
            ['message' => "A Restaurant was found : {$restaurant->getName()} for {$restaurant->getId()} id"]
        );
    }

    #[Route('/{id}',name: 'edit', methods:'PUT')]
    public function edit(int $id):JsonResponse
    {
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        
                if (!$restaurant) {
                    throw $this->createNotFoundException("No Restaurant found for {$id} id");
                }
                $restaurant->setName('Restaurant name updated');
                $this->manager->flush();
                return $this->redirectToRoute('app_api_restaurant_show', ['id' => $restaurant->getId()]);
    }

    #[Route('/{id}',name: 'delete', methods:'DELETE')]
    public function delete(int $id):JsonResponse
    {
        $restaurant = $this->repository->findOneBy(['id' => $id]);
                if (!$restaurant) {
                    throw $this->createNotFoundException("No Restaurant found for {$id} id");
                }
    
                $this->manager->remove($restaurant);
                $this->manager->flush();

                return $this->json(['message' => "Restaurant resource deleted"], Response::HTTP_NO_CONTENT);
        
    }
}



