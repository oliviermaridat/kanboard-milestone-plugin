<?php
namespace Kanboard\Plugin\Milestone;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{

    public function initialize()
    {
        $container = $this->container;
        
        $this->on('app.bootstrap', function ($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__ . '/Locale');
        });
        
        $this->hook->on('template:layout:css', 'plugins/Milestone/Css/milestone.css');
        $this->template->setTemplateOverride('tasklink/show', 'milestone:tasklink/show');
        $this->template->setTemplateOverride('milestone/show', 'milestone:milestone/show');
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
        return '0.0.1';
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