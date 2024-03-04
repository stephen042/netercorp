<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Options;
use Twilio\Values;

abstract class WorkersStatisticsOptions {
    /**
     * @param integer $minutes Filter cumulative statistics by up to ‘x’ minutes in
     *                         the past.
     * @param \DateTime $startDate Filter cumulative statistics by a start date.
     * @param \DateTime $endDate Filter cumulative statistics by a end date.
     * @param string $taskQueueSid Filter the real-time and cumulative statistics
     *                             based on Workers tied to a particular queue
     * @param string $taskQueueName Filter the real-time and cumulative statistics
     *                              based on Workers tied to a particular queue
     * @param string $friendlyName The friendly_name
     * @param string $taskChannel Filter cumulative statistics by TaskChannel.
     * @return FetchWorkersStatisticsOptions Options builder
     */
    public static function fetch($minutes = Values::NONE, $startDate = Values::NONE, $endDate = Values::NONE, $taskQueueSid = Values::NONE, $taskQueueName = Values::NONE, $friendlyName = Values::NONE, $taskChannel = Values::NONE) {
        return new FetchWorkersStatisticsOptions($minutes, $startDate, $endDate, $taskQueueSid, $taskQueueName, $friendlyName, $taskChannel);
    }
}

class FetchWorkersStatisticsOptions extends Options {
    /**
     * @param integer $minutes Filter cumulative statistics by up to ‘x’ minutes in
     *                         the past.
     * @param \DateTime $startDate Filter cumulative statistics by a start date.
     * @param \DateTime $endDate Filter cumulative statistics by a end date.
     * @param string $taskQueueSid Filter the real-time and cumulative statistics
     *                             based on Workers tied to a particular queue
     * @param string $taskQueueName Filter the real-time and cumulative statistics
     *                              based on Workers tied to a particular queue
     * @param string $friendlyName The friendly_name
     * @param string $taskChannel Filter cumulative statistics by TaskChannel.
     */
    public function __construct($minutes = Values::NONE, $startDate = Values::NONE, $endDate = Values::NONE, $taskQueueSid = Values::NONE, $taskQueueName = Values::NONE, $friendlyName = Values::NONE, $taskChannel = Values::NONE) {
        $this->options['minutes'] = $minutes;
        $this->options['startDate'] = $startDate;
        $this->options['endDate'] = $endDate;
        $this->options['taskQueueSid'] = $taskQueueSid;
        $this->options['taskQueueName'] = $taskQueueName;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['taskChannel'] = $taskChannel;
    }

    /**
     * Filter cumulative statistics by up to ‘x’ minutes in the past. This is helpful for statistics for the last 15 minutes, 240 minutes (4 hours), and 480 minutes (8 hours) to see trends. Defaults to 15 minutes.
     * 
     * @param integer $minutes Filter cumulative statistics by up to ‘x’ minutes in
     *                         the past.
     * @return $this Fluent Builder
     */
    public function setMinutes($minutes) {
        $this->options['minutes'] = $minutes;
        return $this;
    }

    /**
     * Filter cumulative statistics by a start date. This is helpful for defining a range of statistics to capture. Input is a string of the format: yyyy-MM-dd’T’HH:mm:ss’Z’.
     * 
     * @param \DateTime $startDate Filter cumulative statistics by a start date.
     * @return $this Fluent Builder
     */
    public function setStartDate($startDate) {
        $this->options['startDate'] = $startDate;
        return $this;
    }

    /**
     * Filter cumulative statistics by a end date. This is helpful for defining a range of statistics to capture. Input is a string of the format: yyyy-MM-dd’T’HH:mm:ss’Z’.
     * 
     * @param \DateTime $endDate Filter cumulative statistics by a end date.
     * @return $this Fluent Builder
     */
    public function setEndDate($endDate) {
        $this->options['endDate'] = $endDate;
        return $this;
    }

    /**
     * Filter the real-time and cumulative statistics based on Workers tied to a particular queue
     * 
     * @param string $taskQueueSid Filter the real-time and cumulative statistics
     *                             based on Workers tied to a particular queue
     * @return $this Fluent Builder
     */
    public function setTaskQueueSid($taskQueueSid) {
        $this->options['taskQueueSid'] = $taskQueueSid;
        return $this;
    }

    /**
     * Filter the real-time and cumulative statistics based on Workers tied to a particular queue
     * 
     * @param string $taskQueueName Filter the real-time and cumulative statistics
     *                              based on Workers tied to a particular queue
     * @return $this Fluent Builder
     */
    public function setTaskQueueName($taskQueueName) {
        $this->options['taskQueueName'] = $taskQueueName;
        return $this;
    }

    /**
     * The friendly_name
     * 
     * @param string $friendlyName The friendly_name
     * @return $this Fluent Builder
     */
    public function setFriendlyName($friendlyName) {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    /**
     * Filter cumulative statistics by TaskChannel. Takes in a Unique Name ("voice", "sms", "default", etc.) or a TaskChannelSid.
     * 
     * @param string $taskChannel Filter cumulative statistics by TaskChannel.
     * @return $this Fluent Builder
     */
    public function setTaskChannel($taskChannel) {
        $this->options['taskChannel'] = $taskChannel;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Taskrouter.V1.FetchWorkersStatisticsOptions ' . implode(' ', $options) . ']';
    }
}