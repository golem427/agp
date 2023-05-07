<?php

namespace App\Tests;

use DateTimeImmutable;
use App\Entity\Attachment;
use App\Entity\Realisation;
use PHPUnit\Framework\TestCase;

class AttachmentTest extends TestCase
{
    public function testSIsTrue()
    {
        $attachment=new Attachment();
        $date = new DateTimeImmutable();


        $attachment->setImage('image')
                    ->setCreatedAt($date);

        $this->assertTrue($attachment->getImage() === 'image');
        $this->assertTrue($attachment->getCreatedAt() === $date);
    }

    public function testSIsFalse()
    {
        $attachment=new Attachment();
        $date = new DateTimeImmutable();

        $attachment ->setImage('image')
                    ->setCreatedAt($date);

        $this->assertFalse($attachment->getImage() === 'false');
        $this->assertFalse($attachment->getCreatedAt() === new DateTimeImmutable());
    }

    public function testSIsEmpty()
    {
        $attachment=new Attachment();

        $this->assertEmpty($attachment->getImage());
    }
}
