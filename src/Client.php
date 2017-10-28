<?php
namespace BotApi;

class Client extends ClientImpl implements ClientInterface
{
    public function __construct(array $config = [])
    {
        ClientImpl::__construct($config);
    }

    public function getUpdates(int $offset, int $limit = 100, int $timeout = 0): array
    {
        $result = $this->apiCall(
            'getUpdates',
            [
                'offset' => $offset,
                'limit' => $limit,
                'timeout' => $timeout
            ]
        );

        return $result;
    }

    public function getMe(): array
    {
        $result = $this->apiCall('getMe');

        return $result;
    }

    public function sendMessage(
        $chat_id,
        string $text,
        string $parse_mode = null,
        bool $disable_web_page_preview = null,
        bool $disable_notification = null,
        string $reply_markup = null
    ): array {
        $params = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];
        if (!is_null($parse_mode)) {
            $params['parse_mode'] = $parse_mode;
        }
        if (!is_null($disable_web_page_preview)) {
            $params['disable_web_page_preview'] = $disable_web_page_preview;
        }
        if (!is_null($disable_notification)) {
            $params['disable_notification'] = $disable_notification;
        }
        if (!is_null($reply_markup)) {
            $params['reply_markup'] = $reply_markup;
        }

        $result = $this->apiCall('sendMessage', $params);

        return $result;
    }
}
