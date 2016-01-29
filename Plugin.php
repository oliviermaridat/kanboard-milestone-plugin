<?php

namespace Kanboard\Plugin\Milestone;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        $container = $this->container;

        $this->on('app.bootstrap', function($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__.'/Locale');
        });

        $this->hook->on('template:layout:css', 'plugins/Milestone/Css/milestone.css');
        
        $this->hook->on('controller:task:show:params', function($task, $links) use ($container) {
            $milestone_links = null;
            if (isset($links['is a milestone of'])) {
                $milestone_links = $links['is a milestone of'];
                //~ unset($links['is a milestone of']);
            }
            return array(
                'links' => $links,
                'milestone_links' => $milestone_links,
            );
        });

        $this->template->hook->attach('template:task:before-tasklink', 'milestone:tasklink/show');
    }
    
    public function getPluginName()
    {
        return t('Milestone');
    }
    
    public function getPluginAuthor()
    {
        return 'Olivier Maridat';
    }
    
    public function getPluginVersion()
    {
        return '1.0.0';
    }
    
    public function getPluginHomepage()
    {
        return 'https://github.com/oliviermaridat/kanboard-milestone-plugin';
    }
    
    public function getPluginDescription()
    {
        return t('The Milestone Plugin for Kanboard adds a section for milestone tasks to show their related tasks.');
    }
}