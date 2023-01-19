<!-- // app/AppKernel.php

// ...
// registerBundles() -->
if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
    // ...
    $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
}