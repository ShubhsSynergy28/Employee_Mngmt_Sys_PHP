<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <link rel="stylesheet" href="../../assets/Styles/Notification.css">
    <script src="../../assets/Scripts/NotificationScript.js"></script>
</head>
<body>
    <?php if (isset($notification) && isset($notificationClass)): ?>
        <div class="notification <?php echo $notificationClass; ?>">
            <p><?php echo $notification; ?></p>
        </div>
        
    <?php endif; ?>
</body>
</html>
