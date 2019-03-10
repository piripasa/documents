<?php
$created = "has been created successfully";
$updated = "has been updated successfully";
$deleted = "has been deleted successfully";

return [
    'document' => [
        'create' => sprintf("%s %s",  'Document', $created),
        'update' => sprintf("%s %s",  'Document', $updated),
        'delete' => sprintf("%s %s",  'Document', $deleted),
    ],
    'user' => [
        'create' => sprintf("%s %s",  'User', $created),
        'update' => sprintf("%s %s",  'User', $updated),
        'delete' => sprintf("%s %s",  'User', $deleted),
    ],
    'upload' => 'Upload has been completed successfully.'
];
?>
