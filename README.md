### Install test task

Clone the next repository from GitHub:
```
git clone https://github.com/lzsolt/sh_test_task.git
```
Switch on the RewriteRule in your settings.

After that go to your MySql console and run the next command:
```
CREATE DATABASE stylehub;
```
Now go to the project root map and run this command:
```
yii migrate
```

### Start worker
Go to the project root directory. Run the follow command:
```
yii worker
```

### Callable endpoints

##### 1) Upload item via json
You can upload items if you send a json POST message to the following endpoint URL:
```
http://stylehub/item
```
It accept message if it is a valid json format and send a json response which contain tha message's event ID. Otherwise it send an error message.

##### 2) Get statics
You can see the uploaded and worked items statistics this URL. You can call it simply GET method.
```
http://stylehub/stat
```
The response contain the items count grouped by months and years.

##### 3) Sent message status by event ID
You can check the uploaded item message status in this endpoint:
```
http://stylehub/event_status/[event_id]
```
If you get a 'event not exists' that's mean is the message worked earlier or not would be uploaded.
If the message is in queue in this case you can see the number of try.