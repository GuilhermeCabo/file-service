File Service
=======

This is a basic file manager for Laravel (made on version 5.8, but can be used on previous versions with some small adjustments)

---



This thing was made to be used with controller resources, like store and update, and also interact with models to save it's related files



### First of all, place FileService.php on the app folder of your project



Then, let's set some basic configuration




First, you need to add some stuff on the model you want to use this:




Place your desired file settings anywhere on your model, with your preferences

``` php
const fileConfig = [
        'file_name' => 'pattern_for_your_files',
        'file_path' => '/default_folder_for_your_files',
        'allowed_extensions' => ['pdf', 'docx', 'other_extensions']
    ];
```

And also the method to return your settings

``` php
public function getFileConfig(){
        return self::fileConfig;
    }
```


Ok, now with this setted up, you can use this properly on your controller


Then, lets configure some things


File Service has three functions: 
  
  * create
  * update 
  * delete


So let's see how to call them on your controllers


Add these variables on the beginning of your controller class

``` php
    private $model;
    private $fileService;
```

And then initialize them with your model and the File Service instances inside your construct method. If you don't have a construct method or have only an empty one, it will look as this:

``` php
    public function __construct(YourModel $model, FileService $fileService)
    {
        $this->model = $model;
        $this->fileService = $fileService;
    }
```

Now let see it in action:

  * basic store exemple:

``` php

    public function store(Request $request)
    {
        $model = new YourModel();
        
        // This is probably what you are looking for
        $model->file_field_on_database = $this->fileService->create(Input::file('file_upload'), $this->model)['file'];
        
        $model->save();
        
        return redirect(route('example.route');
    }
```


   * basic update exemple:

``` php

    public function update(Request $request, $id)
    {
        $model = YourModel::find($id);
        
        // This is probably what you are looking for
        $model->file_field_on_database = $this->fileService->create(Input::file('file_upload'), $this->model)['file'];
        
        $model->save();
        
        return redirect(route('example.route');
    }
```



   * basic delete exemple:

``` php

    public function delete($id)
    {
        $model = YourModel::find($id);
        
        // This is probably what you are looking for
        $this->fileService->delete($model);
        
        $model->delete();
        
        return redirect(route('example.route');
    }
```


### So, that's it. If you face any error or have any suggestions please let me know.
