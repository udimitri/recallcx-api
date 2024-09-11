import { Area, AreaChart, CartesianGrid, ResponsiveContainer, Tooltip, XAxis, YAxis } from "recharts"
import {DashboardLast7Report} from "@/types";

export function GrowthChart({
  data
}: {
  data: DashboardLast7Report
}) {
  return (
    <ResponsiveContainer width="100%" height="100%">
      <AreaChart
        data={data}
        margin={{
          top: 5,
          right: 10,
          left: 10,
          bottom: 0,
        }}
      >
        <Tooltip
          content={({active, payload}) => {
            if (active && payload && payload.length) {
              return (
                <div className="rounded-lg border bg-white p-2 shadow-sm z-10">
                  <div className="grid grid-cols-2 gap-2">
                    <div className="flex flex-col">
                      <span className="text-[0.70rem] uppercase text-muted-foreground">
                        {payload[0].payload.day}
                      </span>
                      <span className="font-bold">
                        {payload[0].value}
                      </span>
                    </div>
                  </div>
                </div>
              )
            }

            return null
          }}
        />
        {/*<CartesianGrid vertical={true} horizontal={false} strokeDasharray="4" strokeWidth={0.5} stroke="#999"/>*/}

        <YAxis hide={true} domain={['dataMin', "auto"]} />
        <XAxis
          dataKey="day"
          axisLine={false}
          tickLine={false}
          tick={{ dy: 10 }}
          interval={"preserveStartEnd"}
          style={{
            fontSize: '0.8rem'
          }}
        />

        <Area
          type="monotone"
          dataKey="count"
          fillOpacity={1}
          fill="#29A4D60D"
          strokeWidth={2}
          stroke="#29A4D6"
          activeDot={{
            r: 8,
            style: {fill: "#29A4D6"},
          }}

        />
      </AreaChart>
    </ResponsiveContainer>
  )
}
