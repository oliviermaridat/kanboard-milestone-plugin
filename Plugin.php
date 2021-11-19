<?php
namespace Kanboard\Plugin\Milestone;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\Milestone\Formatter\TaskGanttLinkAwareFormatter;

class Plugin extends Base
{
    public function initialize()
    {
        $this->hook->on('template:layout:css', array('template' => 'plugins/Milestone/Css/milestone.css'));
        $this->hook->on('template:layout:js', array('template' => 'plugins/Milestone/Js/tableSort.js'));
        $this->template->hook->attach('template:task:dropdown', 'milestone:milestone/dropdown');
        $this->template->setTemplateOverride('task_internal_link/show', 'milestone:task_internal_link/show');
        $this->template->setTemplateOverride('milestone/show', 'milestone:milestone/show');
        $this->template->setTemplateOverride('milestone/table', 'milestone:milestone/table');

	$this->hook->on('controller:tasklink:form:default', function (array $default_values) {
	    return (0 != $this->request->getIntegerParam('link_id')) ? array('link_id' => $this->request->getIntegerParam('link_id')) : array();
	});

        $this->container['taskGanttFormatter'] = $this->container->factory(function ($c) {
            return new TaskGanttLinkAwareFormatter($c);
        });
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getClasses()
    {
        return array(
            'Plugin\Milestone\Model' => array(
                'TaskLinkExtModel'
	    )
        );
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
        return '1.1.5';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/oliviermaridat/kanboard-milestone-plugin';
    }

    public function getPluginDescription()
    {
        return t('The Milestone Plugin for Kanboard adds a section for milestones to show their related tasks.');
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.43';
    }
}
