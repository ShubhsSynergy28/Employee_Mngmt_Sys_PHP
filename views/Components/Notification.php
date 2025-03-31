
    <?php if (isset($notification) && isset($notificationClass)): ?>
        <div class="notification <?php echo $notificationClass; ?>">
            <p><?php echo $notification; ?></p>
        </div>
        
    <?php endif; ?>
