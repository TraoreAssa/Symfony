<?php

namespace MA\PlatformBundle\Controller;

use MA\PlatformBundle\Entity\Advert;
use MA\PlatformBundle\Entity\Image;
use MA\PlatformBundle\Entity\Application;
use MA\PlatformBundle\Entity\AdvertSkill;
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

        $listAdverts = array(
            array(
              'title'   => 'Recherche développpeur Symfony',
              'id'      => 1,
              'author'  => 'Alexandre',
              'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon.',
              'date'    => new \Datetime()),
            array(
              'title'   => 'Mission de webmaster',
              'id'      => 2,
              'author'  => 'Hugo',
              'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet.',
              'date'    => new \Datetime()),
            array(
              'title'   => 'Offre de stage webdesigner',
              'id'      => 3,
              'author'  => 'Mathieu',
              'content' => 'Nous proposons un poste pour webdesigner.',
              'date'    => new \Datetime())
       );


        return $this->render('MAPlatformBundle:Advert:index.html.twig', array('listAdverts' => $listAdverts));
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

        //on recupere le Repository
        $em= $this->getDoctrine()->getManager();
        $repository=$this->getDoctrine()->getManager()->getRepository('MAPlatformBundle:Advert');

        $advert= $repository->find($id);

        if (null == $advert) {
            throw new NotFoundHTTPException("L'annoce de l'id".$id. "n'existe pas en base de données.");
            
        }
        $repository2= $this->getDoctrine()->getManager()->getRepository('MAPlatformBundle:Application');
        $listApplications= $repository2->findBy(array('advert' => $advert));


         // recuperation des skills associées a une annoce donnée
         $listAdvertSkills = $em->getRepository('MAPlatformBundle:AdvertSkill')->findBy(array('advert' => $advert));

         return $this->render("MAPlatformBundle:Advert:view.html.twig", array(
             'advert'=>$advert,
             'listApplications'=>$listApplications,
             'listAdvertSkills'=>$listAdvertSkills,
            
    ));
     
        // $advert = array(
        // 'title'   => 'Recherche développpeur Symfony2',
        // 'id'      => $id,
        // 'author'  => 'Alexandre',
        // 'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon.',
        // 'date'    => new \Datetime()
        // );

        // return $this->render('MAPlatformBundle:Advert:view.html.twig', array(
        // 'advert' => $advert
        // ));
    

        // return $this->render('MAPlatformBundle:Advert:view.html.twig', array(
        //     'id' => $id
        //     ));
        

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
        $em=$this->getDoctrine()->getManager();

        // Récupere l'annonce a modifier
        
        $advert=$em->getRepository('MAPlatformBundle:Advert')->find($id);

        if (null == $advert) {
            throw new NotFoundHTTPException("L'annoce de l'id".$id. "n'existe pas en base de données.");
        }

        $listCategories = $em->getRepository('MAPlatformBundle:Category')->findALL();

        foreach ($listCategories as $category) {
            $advert->addCategory($category);
        }

        $em->flush();

        if($request->isMethod("POST"))
        {
            $request->getSession()->getFlashBag()->add('notice', 'Modification effective');
            return $this->redirectToRoute("ma_platform_view",array('id' => 23));
        }

       

        // $advert = array(
        //     'title'   => 'Recherche développpeur Symfony2',
        //     'id'      => $id,
        //     'author'  => 'Alexandre',
        //     'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon.',
        //     'date'    => new \Datetime()
        //     );

        return $this->render('MAPlatformBundle:Advert:edit.html.twig', array('advert'=>$advert));
        
    }

    public function deleteAction($id)
    {


        $em=$this->getDoctrine()->getManager();

        // Récupere l'annonce a supp
        
        $advert=$em->getRepository('MAPlatformBundle:Advert')->find($id);

        if (null == $advert) {
            throw new NotFoundHTTPException("L'annoce de l'id".$id. "n'existe pas en base de données.");
        }

        foreach ($advert->getCategories() as $category) {
            $advert->removeCategory($category);
        }
        $em->flush();
        
        return $this->render('MAPlatformBundle:Advert:delete.html.twig');
        
    }
   
    public function addAction(Request $request)
    {   

        // Créer l'entité (Creation de mon annonce)
        $advert = new Advert();
        $advert->setTitle('Mission Angular Ionic');
        $advert->setAuthor('Microsoft');
        $advert->setContent('Nous recherchons un développeur spécialisé en Framework front Angular et maitrise également le Framework Mobile Ionic avec les bibliotheques de Cordova. 950$/day');
        $advert->setDate(new \Datetime);
        $advert->setPublished(true);

        //Récupération de l'entyty Manager
        $em=$this->getDoctrine()->getManager();
        //doctrine = Service 

        //------------------- Image --------------
        $image= new Image();
        $image->setUrl('https://www.cnetfrance.fr/i/edit/2018/10/microsoft-1-big.jpg');
        $image->setAlt('Microsoft');

        $advert->setimage($image);
        //$em->persist($image);

        //------------------------Candidature --------------------
        //Création des Applications/Candidature 1
        $application1 = new Application();
        $application1->setAuthor('Marc Dupont');
        $application1->setContent('Je suis un jeune etudiant Développeur Angular avec 5ans d\'experiance a la recherche d\un nouveau post. Je suis disponible dès aujourd\'hui ');
        $application1->setAdvert($advert);
        
        
        
        //Création des Applications/Candidature 2
        $application2 = new Application();
        $application2->setAuthor('Assa TRAORE');
        $application2->setContent('Je suis une Développeuse Intégratrice a la recherche d\'un stage pour valider ma formation Je suis disponible dès aujourd\'hui ');
        $application2->setAdvert($advert);

        
        // on peut ne pas definir ni la date ni la publication car ces attribut sont définis auto dans le constructeur

        //--------------------------- Competences -------------
        $listSkills = $em->getRepository('MAPlatformBundle:Skill')->findALL();

        foreach ($listSkills as $skill) {
            $advertSkill = new AdvertSkill();
            $advertSkill->setAdvert($advert);
            $advertSkill->setSkill($skill);
            $advertSkill->setLevel('Expert');

            $em->persist($advertSkill);
        
        }
        
    
        //INSERT DES OBJET        
        // Persister l'entité <=> la sauvegarder dans la BDD
        $em->persist($advert); // sert a insert (Prépare toi sauvegarder(temporairement))
        $em->persist($application1);
        $em->persist($application2);
        $em->flush(); //Sauvegarde le dans la BDD 


            if ($request->isMethod('POST')){
                $session = $request->getSession();
                // on ajoute une certaine annoce et on la publie
                $session->getflashBag()->add('info', 'Votre annoce a bien été ajouté');
                // j'inscris ce qu'il se passe dans la mémoire flash
            
               return $this->redirectToRoute("ma_platform_view", array('id' => $advert->getId())); 
            }

            // if not method posix_times

                return $this->render('MAPlatformBundle:Advert:add.html.twig', array('advert'=>$advert));
        
        //TOUT CE QUI A EN DESSOUS SON CONCERNE LES MESSAGES NON SPAM !!!!
           
        // Récuperation de mon service en l'istanciant

        // $antispam=$this->container->get('ma_platform.antispam');

        // $text = "...";

        // if ($antispam->isSpam($text)) {
        //     throw new \Exception("Votre message a été détecté comme un spam !");
        // }

      
    }
   
    public function menuAction(Request $request, $limit)
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
   
    public function catAdvertAction($name)
    {   
        $my_array = array($name);
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository("MAPlatformBundle:Advert");
        $listAdverts = $repository->getAdvertWithCategories($my_array);

      return $this->render("MAPlatformBundle:Advert:catAdvert.html.twig", array('listAdverts' => $listAdverts));   
    }
    

    public function editImageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        // 1ere recuperer la bonne annoce
        
        $advert=$em->getRepository("MAPlatformBundle:Advert")->find($id);

        $advert->getImage()->setUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/9/94/M_box.svg/langfr-280px-M_box.svg.png');
        
        $em->flush(); //Sauvegarde le dans la BDD 
        return new Response('OK');

    }
}
