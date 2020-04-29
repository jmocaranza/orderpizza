<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Pizza;
use App\Entity\Topping;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ApiController
 *
 * @Route("/api")
 */
class ApiController  extends FOSRestController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    // ORDER URI's

    /**
     * @Rest\Post("/v1/order.{_format}", name="order_add", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="Order was added successfully"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error was occurred trying to add new order"
     * )
     *
     *
     * @SWG\Parameter(
     *     name="status",
     *     in="body",
     *     type="string",
     *     description="The order status",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Order")
     */
    public function createOrder(Request $request) {

        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $task = [];
        $message = "";

        try {
            $code = 201;
            $error = false;

            $status = $request->get("status", null);
            $pizzas = $request->get("pizzas", null);
            
            if ( !is_null($pizzas) && !is_null($status) ) {

                $order = new Order();
                $order->setStatus($status);
                $order->setDateEntered( new \DateTime('now', new \DateTimeZone('UTC') ) );
                $order->addPizzas( $pizzas );

                $em->persist($order);
                $em->flush();

            } else {
                throw new HttpException(400, "Error: You must to provide all the required fields");
            }

        } catch (Exception $ex) {
            throw new HttpException(500, "Error: {$ex->getMessage()}");
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 201 ? $order : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Put("/v1/order/{id}.{_format}", name="order_edit", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="The order was edited successfully."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to edit the order."
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The order ID"
     * )
     *
     *
     * @SWG\Tag(name="Order")
     */
    public function updateOrder(Request $request, $id) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $task = [];
        $message = "";

        try {
            $code = 200;
            $error = false;
            $status = $request->get("status", null);
            $pizzas = $request->get("pizzas", null);
            $order = $em->getRepository("App:Order")->find($id);

            if (!is_null($order)) {

                if (!is_null($status)) {
                    $order->setStatus($status);
                }

                if (!is_null($pizzas)) {

                    foreach( $order->getPizzas()->getIterator() as $item) {
                        $order->removePizza( $item );
                    }

                    $order->addPizzas( $pizzas );
                        
                }

                $em->persist($order);
                $em->flush();

            } else {
                throw new HttpException(404, "Error: Order id does not exist");
            }

        } catch (Exception $ex) {
            throw new HttpException(500, "Error: {$ex->getMessage()}");
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $order : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Get("/v1/order/{id}.{_format}", name="order_list", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Gets order info based on passed ID parameter."
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="The order with the passed ID parameter was not found or doesn't exist."
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="The order ID"
     * )
     *
     *
     * @SWG\Tag(name="Order")
     */
    public function getOrder(Request $request, $id) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $order = [];
        $message = "";

        try {
            $code = 200;
            $error = false;

            $order_id = $id;
            $order = $em->getRepository("App:Order")->find($order_id);

            if (is_null($order)) {
                throw new HttpException(404, "Error: Order id does not exist");
            }

        } catch (Exception $ex) {
            throw new HttpException(500, "Error: {$ex->getMessage()}");
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $order : $message,
        ];
       
        return new Response($serializer->serialize($response, "json"));
    }    
}
