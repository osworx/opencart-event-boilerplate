# opencart-event-boilerplate
A simple boilerplate for how to use events in OpenCart 3.x https://www.opencart.com

## What it does?
Based on that discussion here in the OpenCart Forum https://forum.opencart.com/viewtopic.php?f=202&t=227654#p839058 and the question "how can this be done" using Events, this package shows how it can be done.

The question was: **send an email to a customer if I register them in the admin**

This sample shows how this "challenge" is solved by a simple Extension and one (1) event.

The package include 3 files:
1. **controller** (include the event itself) and further functions (see install & uninstall)
2. **language** (here en-gb, can be translated into any language)
3. **view** (where the module and event can be en- or disabled without further action)

To install this sample, simply 
1. get your package from the **Release** page (see right)
2. in the backend go to the Installer and select the former downloaded package
3. proceed as displayed
4. now goto to **Extensions > Extensions** select **Modules** and click on the green button next to **Boilerplate event** to install (see inside the controller and ```public function install()``` what is done automatically by performing this action)
5. open now the Extension (click on the blue button) and set the **Status**
6. Ready

**Note:** because the "modification" is done by the event, no cache has to be build (again) [see Step 3 above].

## How can I use this for my own
Also simple, see inside the files and their names.
Everything with **test** in it, rename it to whatver you want.

This sample use the **after** event (see function name in controller):

```public function eventModelUserUserAddUserAfter( &$route, &$args, &$output = null ) {```

where **$route** is the current called route, **$args** an array with values, **$output** the fully parsed template (only available when the **after** method is used).

All 3 variables are initialized as **per reference** (see https://www.php.net/manual/en/language.references.whatdo.php) which means, it the value is changed the changes are valid immediately further.
For more, see https://github.com/opencart/opencart/wiki/Events-System#what-parameters-must-be-added-when-instantiating-an-event-in-an-extension-module
