<?php

return array(
	'controllers' => array(
         'invokables' => array(
             'Pooling\Controller\Pool' => 'Pooling\Controller\PoolingController',
         ),
     ),

	'router' => array(
         'routes' => array(
             'pool' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/pool[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Pooling\Controller\Pool',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'album' => __DIR__ . '/../view',
         ),
     ),
);

?>