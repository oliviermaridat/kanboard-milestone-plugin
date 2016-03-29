Kanboard Milestone Plugin
===================================

This plugin adds a section for milestones to show their related tasks.

The new Milestone section is added between the "Sub-tasks" and the "Internal links" sections as depiected below.

![Milestone example](https://raw.github.com/oliviermaridat/kanboard-milestone-plugin/master/Doc/milestoneview.png)

Author
------

- Olivier Maridat
- License MIT

Installation
------------

- Decompress the archive in the `plugins` folder

or

- Create a folder **plugins/Milestone**
- Copy all files under this directory


Documentation
-------------

Milestone management is based on task links. It provides a proper view to show all the tasks linked with "is a milestone of" to the current task.

To create a milestone:

* Pick a task,
* click on "Add internal link" on the sidebar,
* create a new link with another task by selected the label "is a milestone of",
* and the new "Milestone" element should appear on the picked task view.
* You can add the same link to other tasks that should be finished for this milestone.