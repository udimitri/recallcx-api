import clsx from "clsx";
import { format, isPast } from "date-fns";

export function BroadcastSummary({
  sendAt,
  subject,
  message,
  className,
  bordered = true
}: {
  sendAt: string,
  subject: string,
  message: string,
  className?: string,
  bordered?: boolean
}) {
  const classes = clsx(
    bordered && "border border-zinc-200 ",
    "p-3 flex flex-col gap-1 rounded-lg text-sm",
  );

  return (
    <div className={clsx("flex flex-col", className, bordered && 'gap-3')}>
      <div className={classes}>
        <p className="text-xs font-semibold text-zinc-700">Send at</p>
        <p>{isPast(new Date(sendAt)) ? 'Immediately' : format(sendAt, "PPPp")}</p>
      </div>
      <div className={classes}>
        <p className="text-xs font-semibold text-zinc-700">Subject</p>
        <p>{subject}</p>
      </div>
      <div className={classes}>
        <p className="text-xs font-semibold text-zinc-700">Message</p>
        <p className="whitespace-pre-line">{message}</p>
      </div>
    </div>
  );
}
