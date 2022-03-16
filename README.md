# opencart-event-boilerplate
A simple boilerplate for how to use events in OpenCart (versions 2.x and 3.x) https://www.opencart.com

For **OpenCart 3.x** please go to:
https://github.com/osworx/opencart-event-boilerplate/tree/OpenCart-3.x

For **OpenCart 2.x** please go to:
https://github.com/osworx/opencart-event-boilerplate/tree/OpenCart-2.x

# What is an event?
An **event** is a way to manipulate files - no matter if for the backend (=administration area) or the frontend (= the Webshop).
Events are introduced with OpenCart version 2.x, enhanced with v.3.x and will be the preferred (and only) method to edit files when OpenCart 4.x will be published.
See: https://github.com/opencart/opencart/wiki/Events-System

# History
Before some other Methods could be used.

## VQMod
VQMod https://github.com/vqmod/vqmod 
VQMod is developed by 2 well known OpenCart Developers and could be used also for previous versions of Opencart (1.4.x and 1.5.x).
The base idea was, to modify files "on the fly" with custom code/changes.
Further only those modified files are used, while the original stay intact.
It has many possibilities and settings for a granular fine tuning.
The biggest advantage is, it can be used for any project, not only for Opencart.

## OCMod
With the release of OpenCart 2.x the project owner of OpenCart decided to introduce a new method: OCMod https://github.com/opencart/opencart/wiki/Modification-System
OCMod is build on VQMod, use a similiar syntax (but not so much commands and functions as VQMod).
The biggest advantage over VQMod: it is built into the core and can be used from the start without installing any further extension.

With the publishing of Opencart version 4.x, both - VQMod and OCMod - are removed and cannot be used further without manipulating the core code (e.g. by installing an additional extension).
But the usage is not recommended, because the same functionalities offer **events**

# events
**events** will basically do the same as **VQMod** or **OCMod**, but compared to both, the modifications (the edited files) are stored in the database instead of new files in your folder system.
The system itself checks with every call this database and fetch the stored code - the original files will be untouched.
The problem now will be, if (the basically non-exisisting) VQ- or OCMod modification system (which have to be installed additionally) are used together with events, the system will have troubles and the result will be not that you expect.
***Therefore it is recommended to use events only.***

Someone may say now, with VQ- or OCMod I have/had more possibilities to edit the files.
It is more flexible, easier to maintain, etc.
Well, not true.
With events only your deployment capabilities and coding knowledge is the *limitation*.

And to be true, some *developers* did not really understand how both are really working and are using modification files beyond 10 kb each (and more)!

With an event, only a few lines of code are required.
Beside this, what needs an event to become activ?

## event structure
Basically it will be the same as every extension. It consists of 3 files minimum.

### controller
The main file, will contain all actions needed. And the most important, the event itself (which is called by a **trigger**).

### language file
Basically not really needed, but because this is like an **extension** (and will be installed like an), there should be one.

### view
Also not really needed, but as mentioned before, this event will be used as an usual extension, therefore will have also an output with settings (which can be checked later, e.g. the status en- or disabled).

## Usage
Read more about here: https://github.com/opencart/opencart/wiki/Events-System
Basically an event needs 2 parts:

**trigger**
This is the entry point for every event.
triggers are base functions of the core, for example to add a new user for the administration (in the backend):

***public function addUser($data) {***

inside the model 
***class ModelUserUser extends Model {***

# What is this extension doing
We want, that the system sends automatically each time a new user (e.g. an admin, an editor, a further manager) is created, an email to this new user - with his login data.
To accomplish this, we use an event (this extension you can download via the release page).
The event (the extension) exists of 3 files:

## controller
Described already above

## language (en-gb)
The translation we use in the extension

## view
The output we use at the extenson settings page.

# How to install

## Install the package
Simply download the latest relase, then open the OpenCart backend, navigate via the Menu to **Extensions > installer**, select this package you have downloaded and follow the onscreen advice.
After the installation process, no further action has to be taken - events do not need any cache refresh!

## Install the extension
Now via the Menu go to **Extensions > Extensions >> Modules** and click on the green button next to Boilerplate event
This will install the extension and create the required database entries for the event automatically.
Beside this, the correct permissions are set also automatically.

## Settings
This extension has only one (1)setting: the **status**
With that, we can easily en- and disable the whole extension (and the event too).
If the extension shall be enabled, but only the event disabled, go to **Extensions > Events** and disable the event there.

Note: for demonstration the extension has a 2nd tab (setting there has no further function).
Also some help texts.

### Anything else?
Not really, this sample here is only to demonstrate how an event can be established.
With a simple and easy way to manage.
Study the code, improve it, share your knowledge.
Let the community know what you think, or what could be done better.

The whole code is ready for php 8.1.x (and of course previous php versions).

If you find an error or bug, make a PR (Pull Request).
Also if you have an improvement.

### Want to build your own extension to add an event
Simply get a copy of this package.
All files and the function having **test** in it, rename to whatever you need/want and save.

For example, the controller is named currently: **test.php**
Rename the file to (e.g.) **my_extension.php**
Same goes for the language and view file.

Inside the **controller file** you have to rename the function from **ControllerExtensionModuleTest** to **ControllerExtensionModuleMyExtension**
Rename also the fields at $_extension and $_route (if a model is used, here as well)

Adopt the function name to your needs, e.g. currently **eventModelUserUserAddUserAfter** to **eventModelFileFileFunctionAfter** based on what you want to achieve.
Inside this function, do whatever you want to do.

***Note***
Because this extension has only 3 files, is installed as an extension, no install.xml file is needed.
***install.xml*** was used earlier with the above mentioned extensions (VQMod and OCMod). 
Inside this file are the ***instructions*** what and how to modify.

Because this is an event only, and ***modifications*** are done by this method, the former install.xml is not needed anymore.
Though it could be added, because if it does not exist, the list of installed extensions will not contain this extension.
I leave it up to you if you want to use such a file.
