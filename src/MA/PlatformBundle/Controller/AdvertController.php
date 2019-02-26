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

use \Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use \Symfony\Component\Form\Extension\Core\Type\FormType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\TextareaType;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use MA\PlatformBundle\Form\ImageType;
use MA\PlatformBundle\Form\CategoryType;
use MA\PlatformBundle\Form\AdvertType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class AdvertController extends Controller //controler => fonction get 
{
    public function indexAction($page)
    {
        if (!$page) {
            $page=1;
        }
        if($page<1){
            throw $this->createNotFoundException('Page"' . $page . 'inexistante.');
        }

        $nbPerPage=5; // on indique qu l'on souhaite avoir 3 annonce par page

        $em= $this->getDoctrine()->getManager();
        $repository= $em->getRepository('MAPlatformBundle:Advert');
        $listAdverts =  $repository->getAdverts($page, $nbPerPage);
        
        //Calcule du nombre total de pages
        $nbPages= ceil(count($listAdverts)/$nbPerPage);

        if($page>$nbPages){
            throw $this->createNotFoundException('Page' . $page . "inexistante");
        }

        //Recuperer toute les mission de la BDD!!
        return $this->render('MAPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages' => $nbPages , 
            'page' => $page  
        ));
        // == a ce qui est en dessous!



    //     $listAdverts = array(
    //         array(
    //           'title'   => 'Recherche développpeur Symfony',
    //           'id'      => 1,
    //           'author'  => 'Alexandre',
    //           'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon.',
    //           'date'    => new \Datetime()),
    //    );
        // return $this->render('MAPlatformBundle:Advert:index.html.twig', array('listAdverts' => $listAdverts));

        // return new Response('Notre propre Hello World ! ');
        // $content0 =  $this->get('templating')->render('MAPlatformBundle:Advert:index.html.twig', array('prenom' => 'Assa') );

        // $content =  $this->get('templating')->render('MAPlatformBundle:Advert:index.html.twig', array('id' => 5));
        // //           controler =>                                   la vue      
        
        

        // ------ Comment on genere une URL
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



    // ----------------------------------- VIEW ----------------------------------------------
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

        // Testons l'extesion doctrine slug
         $advert_test = new Advert();
         $advert_test->setTitle('Recherche de développeur Java!');
         $image= new Image();
         $image->setUrl('https://img-19.ccm2.net/WA-cJN4p7hECHq8h5_MUthRKFH4=/f60227320e7a48a8b0a6d80511934148/ccm-faq/38925-U7y54U3xG1TORMVw-s-.png');
         $image->setAlt('Vend moi du reve !!');
 
         $advert_test->setimage($image);
         $advert_test->setAuthor('Biss Traore');
         $advert_test->setContent('Développeur d\'une application Java.');
         $advert_test->setPublished(true);

         $em->persist($advert_test);
         $em->flush(); //Sauvegarde le dans la BDD 


         return $this->render("MAPlatformBundle:Advert:view.html.twig", array(
             'advert'=>$advert,
             'advert_test'=>$advert_test,
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

        // ------ 
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



//------------------------------------------ EDIT ---------------------------------------------------
    public function editAction($id, Request $request)
    {
        $advert=$this->getDoctrine()->getManager()->getRepository('MAPlatformBundle:Advert')->find($id);
        //on va creer un FormBuilder grace a un service factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $advert);

        // A ce stade formBuilder est un form lié a mon objet advert

        // maintenant je dois ajouter les champs a l'entité a notre formulaire

        $formBuilder->add('date', DateType::class);
        $formBuilder->add('title', TextType::class);
        $formBuilder->add('content', TextareaType::class);
        $formBuilder->add('author', TextType::class);
        $formBuilder->add('published', CheckboxType::class, array('required'=>false));
        $formBuilder->add('save', SubmitType::class);

        // on s'occupe des candidatures, categories .. plus tard <DOCTYPE html> 
        // a partir du constructeur de form (fromBuilder), je gere mon formulaire

     
        // ICI NOUS ALLONS GERER LA PARTIE FORMULAIRE !!
        $form =$formBuilder->getform();

        if ($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush(); //Sauvegarde le dans la BDD 
    
                $request->getSession()->getFlashBag()->add('info', 'Votre annoce a bien été ajouté');

                return $this->redirectToRoute('ma_platform_view', array('id'=> $advert->getId()));
            }

      


        //     $session = $request->getSession();
        //     // on ajoute une certaine annoce et on la publie
        //     $session->getflashBag()->add('info', 'Votre annoce a bien été ajouté');
        //     // j'inscris ce qu'il se passe dans la mémoire flash
        
        //    return $this->redirectToRoute("ma_platform_view", array('id' => $advert->getId())); 
        }

        // if not method posix_times

      
        return $this->render('MAPlatformBundle:Advert:add.html.twig', array
        ('form'=>$form->createView()
        ));


    }






//------------------------------------------ DELETE ---------------------------------------------------
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






   //----------------------------------------- ADD ACTION ---------------------------------------------
    public function addAction(Request $request)
    {   
        //Récupération de l'entyty Manager
        $em=$this->getDoctrine()->getManager();
        //doctrine = Service 

        //on crée un objet advert
        $advert = new Advert();
        
        $advert->setDate(new \Datetime());

        $image= new Image();
        $image->setUrl('https://www.cnetfrance.fr/i/edit/2018/10/microsoft-1-big.jpg');
        $image->setAlt('Vend moi du reve');

        $advert->setImage($image);


        //on va creer un FormBuilder grace a un service factory
        // $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $advert);

        // // A ce stade formBuilder est un form lié a mon objet advert

        // // maintenant je dois ajouter les champs a l'entité a notre formulaire

        // $formBuilder->add('date', DateType::class);
        // $formBuilder->add('title', TextType::class);
        // $formBuilder->add('content', TextareaType::class);
        // $formBuilder->add('author', TextType::class);
        // $formBuilder->add('published', CheckboxType::class, array('required'=>false));
        // //Apres nos doctrine:generate:form MAPlatformBundle:Image et category, auto generation de formulaires - voici comment on integere ces formulaires dans notre formulaire existant
        // $formBuilder->add('image', ImageType::class);
        // $formBuilder->add('categories', CollectionType::class, array(
        //     'entry_type' => CategoryType::class,
        //     'allow_add' => true, 
        //     'allow_delete' => true
        // ));
        // $formBuilder->add('save', SubmitType::class);

        // on s'occupe des candidatures, categories .. plus tard <DOCTYPE html> 
        // a partir du constructeur de form (fromBuilder), je gere mon formulaire

     
        // ICI NOUS ALLONS GERER LA PARTIE FORMULAIRE !!
        // $form =$formBuilder->getform();
        $form = $this->get('form.factory')->create(AdvertType::class, $advert);

        if ($request->isMethod('POST') &&  $form->handleRequest($request)->isValid){

            // $form->handleRequest($request);
            // if($form->isValid())
            // {
                $em=$this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush(); //Sauvegarde le dans la BDD 
    
                $request->getSession()->getFlashBag()->add('info', 'Votre annoce a bien été ajouté');

                return $this->redirectToRoute('ma_platform_view', array('id'=> $advert->getId()));
            // }

        //     $session = $request->getSession();
        //     // on ajoute une certaine annoce et on la publie
        //     $session->getflashBag()->add('info', 'Votre annoce a bien été ajouté');
        //     // j'inscris ce qu'il se passe dans la mémoire flash
        
        //    return $this->redirectToRoute("ma_platform_view", array('id' => $advert->getId())); 
        }

        // if not method posix_times

      
        return $this->render('MAPlatformBundle:Advert:add.html.twig', array
        ('form'=>$form->createView()));


        // // ------------------- Créer l'entité (Creation de mon annonce)---------------------------------
        // $advert = new Advert();
        // $advert->setTitle('Mission Angular Ionic');
        // $advert->setAuthor('Microsoft');
        // $advert->setContent('Nous recherchons un développeur spécialisé en Framework front Angular et maitrise également le Framework Mobile Ionic avec les bibliotheques de Cordova. 950$/day');
        // $advert->setDate(new \Datetime);
        // $advert->setPublished(true);

        
        // //------------------- Image -----------------
        // $image= new Image();
        // $image->setUrl('https://www.cnetfrance.fr/i/edit/2018/10/microsoft-1-big.jpg');
        // $image->setAlt('Microsoft');

        // $advert->setimage($image);
        // //$em->persist($image);

        // //------------------------Candidature --------------------
        // //Création des Applications/Candidature 1
        // $application1 = new Application();
        // $application1->setAuthor('Marc Dupont');
        // $application1->setContent('Je suis un jeune etudiant Développeur Angular avec 5ans d\'experiance a la recherche d\un nouveau post. Je suis disponible dès aujourd\'hui ');
        // $application1->setAdvert($advert);

        // // on peut ne pas definir ni la date ni la publication car ces attribut sont définis auto dans le constructeur

        // //--------------------------- Competences -------------
        // $listSkills = $em->getRepository('MAPlatformBundle:Skill')->getAdverts();

        // foreach ($listSkills as $skill) {
        //     $advertSkill = new AdvertSkill();
        //     $advertSkill->setAdvert($advert);
        //     $advertSkill->setSkill($skill);
        //     $advertSkill->setLevel('Expert');

        //     $em->persist($advertSkill);
        
        // }
        
    
        // //INSERT DES OBJET        
        // // Persister l'entité <=> la sauvegarder dans la BDD
        // $em->persist($advert); // sert a insert (Prépare toi sauvegarder(temporairement))
        // $em->persist($application1);
        // $em->persist($application2);
        // $em->flush(); //Sauvegarde le dans la BDD 


        // return $this->render('MAPlatformBundle:Advert:add.html.twig', array('advert'=>$advert));
        
        //TOUT CE QUI A EN DESSOUS SON CONCERNE LES MESSAGES NON SPAM !!!!
           
        // Récuperation de mon service en l'istanciant

        // $antispam=$this->container->get('ma_platform.antispam');

        // $text = "...";

        // if ($antispam->isSpam($text)) {
        //     throw new \Exception("Votre message a été détecté comme un spam !");
        // }

      
    }





   //------------------------------------------------------------- MENU ACTION -----------------------------------------------------------
    public function menuAction(Request $request, $limit)
    {   
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository('MAPlatformBundle:Advert');
        $listAdverts = $repo->findBy(
            array(), // Pas de critère particulier
            array('date' => 'desc'), // trie par date decroissante
            $limit, // on affiche donc $limit annonce
            0 // Ps d'offset on commence au 1er elt du tableau resultat
        );

    //   $listAdverts= array(
    //       array('id'=> 101, 'title'=> 'Recherche Developpeur Symfony'),
    //       array('id'=> 102, 'title'=> 'Mission Symfony'),
    //       array('id'=> 103, 'title'=> 'Stage Angular'),
    //       array('id'=> 104, 'title'=> 'Developpeur Node'),
    //       array('id'=> 105, 'title'=> 'Architecte logiciel')
    //   );

      return $this->render("MAPlatformBundle:Advert:menu.html.twig", array('listAdverts' => $listAdverts));   
    }
   
    public function catAdvertAction($name)
    {   
        $my_array = array($name);
        $em=$this->getDoctrine()->getManager();
        $repository = $em->getRepository("MAPlatformBundle:Advert");
        $listAdverts = $repository->getAdvertsWithCategories($my_array);

      return $this->render("MAPlatformBundle:Advert:catAdvert.html.twig", array('listAdverts' => $listAdverts));   
    }
    




    //---------------------------------------- EDIT IMAGE -------------------------------------------------------
    public function editImageAction($id)
    {

        // Récupere l'objet en base de donnée

         //Récupération de l'entyty Manager
         $em=$this->getDoctrine()->getManager();
        //doctrine = Service 

        //on crée un objet advert
        $advert = new Advert();
        
        $advert->setDate(new \Datetime());

        $image= new Image();
        $image->setUrl('https://www.cnetfrance.fr/i/edit/2018/10/microsoft-1-big.jpg');
        $image->setAlt('Vend moi du reve');

        $advert->setImage($image);


                        //on va creer un FormBuilder grace a un service factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $advert);

        // A ce stade formBuilder est un form lié a mon objet advert

        // maintenant je dois ajouter les champs a l'entité a notre formulaire

        $formBuilder->add('date', DateType::class);
        $formBuilder->add('title', TextType::class);
        $formBuilder->add('content', TextareaType::class);
        $formBuilder->add('author', TextType::class);
        $formBuilder->add('published', CheckboxType::class, array('required'=>false));
        $formBuilder->add('save', SubmitType::class);

        // on s'occupe des candidatures, categories .. plus tard <DOCTYPE html> 
        // a partir du constructeur de form (fromBuilder), je gere mon formulaire

     
        // ICI NOUS ALLONS GERER LA PARTIE FORMULAIRE !!
        $form =$formBuilder->getform();

        if ($request->isMethod('POST')){

            if($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush(); //Sauvegarde le dans la BDD 
    
                $request->getSession()->getFlashBag()->add('info', 'Votre annoce a bien été ajouté');

                return $this->redirectToRoute('ma_platform_view', array('id'=> $advert->getId()));
            }
        //     $session = $request->getSession();
        //     // on ajoute une certaine annoce et on la publie
        //     $session->getflashBag()->add('info', 'Votre annoce a bien été ajouté');
        //     // j'inscris ce qu'il se passe dans la mémoire flash
        
        //    return $this->redirectToRoute("ma_platform_view", array('id' => $advert->getId())); 
        }

        // if not method posix_times

      
        return $this->render('MAPlatformBundle:Advert:add.html.twig', array
        ('form'=>$form->createView()
        ));
        
        $em = $this->getDoctrine()->getManager();
        
        // 1ere recuperer la bonne annoce
        
        $advert=$em->getRepository("MAPlatformBundle:Advert")->find($id);

        $advert->getImage()->setUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/9/94/M_box.svg/langfr-280px-M_box.svg.png');
        
        $em->flush(); //Sauvegarde le dans la BDD 
        return new Response('OK');
    }
}
