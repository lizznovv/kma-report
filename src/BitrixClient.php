<?php

require_once '../src/Task.php';

class BitrixClient
{
    private string $webhookUrl;
    private int $groupId;

    public function __construct(string $webhookUrl, int $groupId)
    {
        $this->webhookUrl = $webhookUrl;
        $this->groupId = $groupId;
    }

    public function getClosedTasks(DateTime $from = null, DateTime $to = null): array
    {
        $allTasks = [];
        $start = 0;

        do
        {
            $filter = [
                'GROUP_ID' => $this->groupId,
            ];

            if ($from !== null) {
                $filter['>=CLOSED_DATE'] = $from->format('c');
            }
            if ($to !== null) {
                $filter['<=CLOSED_DATE'] = $to->format('c');
            }

            $queryUrl = $this->webhookUrl . 'tasks.task.list.json';
            $queryData = [
                'filter' => $filter,
                'start' => $start,
            ];

            //$response = file_get_contents($queryUrl . '?' . $queryData);
            $response = file_get_contents(__DIR__ . '/../test_data.json');
            $result = json_decode($response, true);

            if (!empty($result['result']['tasks'])) {
                foreach ($result['result']['tasks'] as $taskData) {

                    $closedDate = new DateTime($taskData['closedDate']);

                    if ($from !== null && $closedDate < $from) {
                        continue;
                    }
                    if ($to !== null && $closedDate > $to) {
                        continue;
                    }

                    $allTasks[] = new Task(
                        (int)$taskData['id'],
                        $closedDate
                    );
                }
            }

        } while ($start);

        return $allTasks;
    }
}