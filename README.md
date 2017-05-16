Kanboard Milestone Plugin
===================================

This plugin adds a section for milestones to show their related tasks.

The new Milestone section is added between the "Sub-tasks" and the "Internal links" sections as depicted below.

![Milestone example](https://raw.github.com/oliviermaridat/kanboard-milestone-plugin/master/Doc/milestoneview.png)

It also uses "is a milestone of" and "is blocked by" task links to infer start and due dates if you are using the [Gantt Plugin](https://github.com/kanboard/plugin-gantt).

![Gantt view example](https://raw.github.com/oliviermaridat/kanboard-milestone-plugin/master/Doc/Gantt-Milestone-and-blocked.png)

Author
------

- Olivier Maridat
- License MIT

Requirements
------

* Kanboard >= 1.0.37

Installation
------------

You have the choice between 3 methods:

- Install the plugin from the Kanboard plugin manager in one click
- Download the zip file and decompress everything under the directory plugins/Milestone
- Clone this repository into the folder plugins/Milestone

Note: Plugin folder is case-sensitive.

Documentation
-------------

Milestone management is based on task links. It provides a proper view to show all the tasks linked with "is a milestone of" to the current task.

To create a milestone:

* Pick a task,
* click on "Add internal link" on the sidebar,
* create a new link with another task by selected the label "is a milestone of",
* and the new "Milestone" element should appear on the picked task view.
* You can add the same link to other tasks that should be finished for this milestone.
