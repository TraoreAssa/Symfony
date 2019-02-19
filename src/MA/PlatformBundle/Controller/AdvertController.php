<?php

namespace MA\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\NotFoundHttpException;



class AdvertController extends Controller //controler => fonction get 
{
    public function indexAction($page)
    {
        if (!$page) {
            $page=1;
        }
        if($page<1){
            throw new NotFoundHttpException('Page' . $page . "inexistante");
        }
        return $this->render('MAPlatformBundle:Advert:index.html.twig', array('num' => $page));
        // return new Response('Notre propre Hello World ! ');
        // $content0 =  $this->get('templating')->render('MAPlatformBundle:Advert:index.html.twig', array('prenom' => 'Assa') );

        // $content =  $this->get('templating')->render('MAPlatformBundle:Advert:index.html.twig', array('id' => 5));
        // //           controler =>                                   la vue                              

        // $url=$this->get('router')->generate("ma_platform_view", array('id' => 5),UrlGeneratorInterface::ABSOLUTE_URL);
        // return new Response("URL de l'annoce numero 5 est " .$url);

        // if(!$page){
        //     $page = 1;
        // }
        // return new Response("Affichage de ma page numero " .$page);
        
    }


    //{{}} AFFICHAGE     {%  %} FAIRE QQCHOSE  {#  #} COMMENTAIRE
    // filtre {{ date | date('d/m/Y')}}
    // {{"Il y a %s pommes et %s poires | format(153, nb_poires)"}}

    // app.session | app.request | app.environment | app.debug | app.user  ==> variable a connaitre

    public function viewAction($id, Request $request)
    {

        return $this->render('MAPlatformBundle:Advert:view.html.twig', array(
            'id' => $id
            ));
        

        // $tag = $request->query->get('tag');

        // //********Redirection vers la page HOME*********
        // if($id==1){
        // $url=$this->get('router')->generate("ma_platform_home");
        // return new RedirectResponse($url); // redirige
        // }

        // if($id==2){
        // $url=$this->get('router')->generate("ma_platform_home");
        // return $this->redirect($url); // redirige
        // }

        // if($id==3){
        // return $this->redirectToRoute("ma_platform_home"); // redirige
        // }

        // if($id>30){
        // return $this->render('MAPlatformBundle:Advert:view.html.twig', array(
        //     'id' => $id,
        //     ));
        // }

        // if($id==12){
        //     $response= new Response(json_encode(array('id' => $id)));
        //     $response->headers->set('Content-Type',' application/json');
        //     return $response;
        // }
        // $response = new JsonResponse(array('id'=>$id));

        // $session= $request->getSession();
        // $userId=$session->get('user_id');
        // $session->set('user_id', 101);
        // return new Response ("<body>Coucou je suis une page de test, je n'ai rien à dire</body>");


        //Afficher une page
        // return $this->render('MAPlatformBundle:Advert:view.html.twig', array(
        //     'id' => $id,
        //     'tag' => $tag
        //     ));

        // $type = $request->headers->get('content-type');
        // if($request->isMethod('POST')){
        //     return new Response ("C'est une methode de type POST");
        // }
        // if($request->isMethod('GET')){
        //     return new Response ("C'est une methode de type GET");
        // }
        // if($request->isXmlHttpRequest()){
        //     return new Response ("C'est une methode de type AJAX");
        // }

        // return new Response("Affichage de mon annoce numero " . $id . ", avec le tag " . $tag, Response::HTTP_OK,['content-type' => 'text/html']);


        // $response = new Response();
        // $response->setContent("il s'agit ici d'une page erreur 404");

        // $response->setStatusCode(Response::HTTP_NOT_FOUND);


        //http://localhost:8000/platform/advert/5?name=assa
        
    }

    public function viewSlugAction($year, $slug, $format)
    {
        return new Response(
            "On porrait afficher l'annoce correspondant au slug '" .$slug. "', créée en ". $year." et au format " .$format."."
            );
        
    }

    public function editAction($id, Request $request)
    {
        if($request->isMethod("POST"))
        {
            $request->getSession()->getFlashBag()->add('notice', 'Modification effective');
            return $this->redirectToRoute("ma_platform_view",array('id' => 23));
        }
        return $this->render('MAPlatformBundle:Advert:edit.html.twig');
        
    }

    public function deleteAction($id)
    {
        return $this->render('MAPlatformBundle:Advert:delete.html.twig');
        
    }
   
    public function addAction(Request $request)
    {   
        if ($request->isMethod('POST')){
            $session = $request->getSession();
            // on ajoute une certaine annoce et on la publie
            $session->getflashBag()->add('info', 'Annoce a été ajouté');
            // j'inscris ce qu'il se passe dans la mémoire flash
            $session->getflashBag()->add('info', 'je repete l annoce a été ajouté');
            $session->getflashBag()->add('info', 'Hello annoce a été ajouté');
            $session->getflashBag()->add('info', 'Bon derniere fois : l annoce a été ajouté');
            // ajouter d'autre messages
           
           return $this->redirectToRoute("ma_platform_view", array('id' => 25)); 
        }

        return $this->render('MAPlatformBundle:Advert:add.html.twig');
        
    }
   
    public function menuAction(Request $request)
    {   
      $listAdverts= array(
          array('id'=> 101, 'title'=> 'Recherche Developpeur Symfony'),
          array('id'=> 102, 'title'=> 'Mission Symfony'),
          array('id'=> 103, 'title'=> 'Stage Angular'),
          array('id'=> 104, 'title'=> 'Developpeur Node'),
          array('id'=> 105, 'title'=> 'Architecte logiciel')
      );
      return $this->render("MAPlatformBundle:Advert:menu.html.twig", array('listAdverts' => $listAdverts));


        
    }
}
