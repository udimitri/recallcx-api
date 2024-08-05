import {Broadcast} from "@/types";
import {BroadcastSummary} from "@/Pages/Broadcasts/Create/Partials/BroadcastSummary";
import {Button} from "@headlessui/react";

export default function BroadcastCreated({
  broadcast,
}: Readonly<{
  broadcast: Broadcast
}>) {
  return (
    <div className="w-full">
      <div className="flex flex-col gap-4 items-center mt-16 mx-auto w-fit">
        <p className="text-6xl">🥳</p>
        <h2 className="font-semibold text-xl max-w-sm text-center">Your broadcast has been created!</h2>
        <div className="flex flex-col gap-4 items-center mt-4 mx-auto border border-zinc-200 rounded-xl p-4 w-fit">
          <BroadcastSummary
            sendAt={broadcast.send_at}
            subject={broadcast.subject}
            message={broadcast.message}
            className="max-w-md"
            bordered={false}
          />
          <Button href="/broadcasts" className="w-full mb-2">Done</Button>
        </div>
      </div>
    </div>
  );
}
