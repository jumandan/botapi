<?php
namespace BotApi;

interface ClientInterface
{
    const VERSION = '1.0.0';

    /**
     * This method receive incoming updates using long polling.
     *
     * @param int $offset Identifier of the first update to be returned.
     * @param int $limit Limits the number of updates to be retrieved.
     * @param int $timeout Timeout in seconds for long polling.
     *
     * @retrun array
     */
    public function getUpdates(int $offset, int $limit = 100, int $timeout = 0): array;

    /**
     * This method receive basic information about bot.
     */
    public function getMe(): array;

    /**
     * This method send text message.
     *
     * @param int or string $chat_id Unique identifier for the target char or username of the target channel.
     * @param string $text Text of the message to be sent.
     * @param string $parse_mode Send Markdown or HTML
     * @param bool $disable_web_page_preview Disables link previews for links in this message
     * @param bool $disable_notification Send the message silently (with no sound).
     * @param int reply_to_message_id If the message is a reply, ID of the original message.
     * @param string reply_markup Additional interface options. A JSON-serialized object.
     */
    public function sendMessage(
        $chat_id,
        string $text,
        string $parse_mode = null,
        bool $disable_web_page_preview = null,
        bool $disable_notification = null,
        string $reply_markup = null
    );
}
