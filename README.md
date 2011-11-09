# About #

UUIDs are a great way to attach records of the same structure belong to a wide varity of other models without complicated constraints and pre save filters.
The problem is that they are unidirectional identifiers, e.g. when you have to models with UUIDs as keys, and a belonging third model, the first two know where to fetch their attached records, but the third model can't fetch the model a given record is attached to.
This plugins aims to solve this problem by providing a central pool of UUIDs and utilities to register, deregister and resolve UUIDs.

# Howto use #

To add your models records the the UUID pool use the UUIDable behaviour:
``public $actsAs = array('UUIDable.UUIDable');``
And make the UUID column the primary key, so it can be accessed by YourModel->id.
Your models UUIDs will now be added to the pool whenever you create a record, and deleted whenever you delete one.

To resolve UUIDs, instantiate the model `UUIDable.UUIDRepository` and use it's resolve method:

```PHP
App::import('Model', 'UUIDable.UUIDRepository');
$u = new UUIDRepository();
$target = $u->resolve('4ebab256-22ec-4187-a112-675d7f000101');
```

It will give you a new instance of the model the UUID belongs to, initialised onto the given UUID.
