<?php

namespace Tests\Functional;

use PubNub\Endpoints\ChannelGroups\ListChannelsInChannelGroup;
use PubNub\Endpoints\ChannelGroups\RemoveChannelGroup;
use PubNub\Exceptions\PubNubValidationException;


class RemoveChannelGroupTest extends \PubNubTestCase
{
    public function testValidatesGroupNotEmpty()
    {
        try {
            $this->pubnub->removeChannelGroup()->sync();
            $this->fail("No exception was thrown");
        } catch (PubNubValidationException$exception) {
            $this->assertEquals("Channel group missing", $exception->getMessage());
        }
    }

    public function testRemoveGroup()
    {
        $listGroup = new RemoveChannelGroupExposed($this->pubnub);

        $listGroup->channelGroup("blah");

        $this->assertEquals(
            sprintf(
                "/v1/channel-registration/sub-key/%s/channel-group/%s/remove",
                $this->pubnub->getConfiguration()->getSubscribeKey(),
                "blah"
            ),
            $listGroup->buildPath()
        );

        $this->assertEquals(
            [
                "pnsdk" => $this->pubnub->getSdkFullName(),
                "uuid" => $this->pubnub->getConfiguration()->getUuid(),
            ],
            $listGroup->buildParams()
        );
    }
}


class RemoveChannelGroupExposed extends RemoveChannelGroup
{
    public function buildParams()
    {
        return parent::buildParams();
    }

    public function buildPath()
    {
        return parent::buildPath();
    }
}