<?php

namespace App\Controller;

use App\Util\PostItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $template = 'default/index.html.twig';
        $args = [

        ];
        return $this->render($template, $args);
    }

    /**
     * @Route("/timer", name="timer_default")
     */
    public function timerDefault(): Response
    {
        // default 10 mins
        $n = 10;
        $template = 'default/timer.html.twig';
        $args = [
            'timerDuration' => $n
        ];
        return $this->render($template, $args);
    }

    /**
     * @Route("/timer/{n}", name="timer")
     */
    public function timer($n): Response
    {
        $template = 'default/timer.html.twig';
        $args = [
            'timerDuration' => $n
        ];
        return $this->render($template, $args);
    }


    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacy(): Response
    {
        $template = 'default/privacy.html.twig';
        $args = [

        ];
        return $this->render($template, $args);
    }


    /**
     * @Route("/oddeven/{n}", name="oddeven")
     */
    public function oddeven($n): Response
    {
        $message = "$n is an ODD number";
        if($this->isEven($n)){
            $message = "$n is an EVEN number";
        }
        $template = 'default/oddeven.html.twig';
        $args = [
            'message' => $message
        ];
        return $this->render($template, $args);
    }

    function isEven($n)
    {
        $remainder = ($n % 2);
        if($remainder == 0)
            return true;

        return false;
    }

    /**
     * @Route("/items", name="items")
     */
    public function items(): Response
    {
        $items = [];
        $item1 = new PostItem();
        $item1->setDescription('letter');
        $item1->setLengthMeters(0.2);
        $items[] = $item1;

        $item2 = new PostItem();
        $item2->setDescription('small package');
        $item2->setLengthMeters(0.3);
        $items[] = $item2;

        $item3 = new PostItem();
        $item3->setDescription('surf board');
        $item3->setLengthMeters(1.2);
        $items[] = $item3;


        $template = 'default/items.html.twig';
        $args = [
            'items' => $items
        ];
        return $this->render($template, $args);
    }

}
