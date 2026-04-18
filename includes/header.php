<?php
/**
 * Shared HTML head for app pages. Uses Bootstrap + warm minimalistic theme.
 * Variables: $pageTitle, $pageCss (array of extra CSS paths)
 */
$pageTitle = $pageTitle ?? 'Pizza Paradizo';
$pageCss   = $pageCss   ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pizza Paradizo — Delicious handcrafted pizzas delivered to your door.">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Pizza Paradizo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="assets/css/variables.css">
    <?php foreach ($pageCss as $css): ?>
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>
    <style>body { font-family: var(--font-body); }</style>
</head>
<body>
